<?php

class SesionClase
{
    public static function crear(array $datos): int
    {
        $pdo = Database::obtenerConexion();
        $token = bin2hex(random_bytes(16)); // 32 caracteres aleatorios, no adivinables

        $stmt = $pdo->prepare(
            'INSERT INTO sesiones_clase
                (curso_id, fecha, hora_inicio, hora_limite_asistencia, hora_limite_tardanza, tema, token_formulario, estado)
             VALUES (?, ?, ?, ?, ?, ?, ?, "abierta")'
        );
        $stmt->execute([
            $datos['curso_id'],
            $datos['fecha'],
            $datos['hora_inicio'],
            $datos['hora_limite_asistencia'],
            $datos['hora_limite_tardanza'],
            $datos['tema'] !== '' ? $datos['tema'] : null,
            $token,
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function obtenerPorCurso(int $cursoId): array
    {
        self::cerrarVencidas($cursoId);

        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('SELECT * FROM sesiones_clase WHERE curso_id = ? ORDER BY fecha DESC, hora_inicio DESC');
        $stmt->execute([$cursoId]);
        return $stmt->fetchAll();
    }

    public static function obtenerPorId(int $id, int $cursoId): ?array
    {
        self::cerrarVencidas($cursoId);

        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('SELECT * FROM sesiones_clase WHERE id = ? AND curso_id = ?');
        $stmt->execute([$id, $cursoId]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }

    public static function obtenerPorToken(string $token): ?array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare(
            'SELECT s.*, c.nombre AS curso_nombre, c.profesor_id
             FROM sesiones_clase s
             JOIN cursos c ON c.id = s.curso_id
             WHERE s.token_formulario = ?'
        );
        $stmt->execute([$token]);
        $resultado = $stmt->fetch();

        if ($resultado) {
            self::cerrarVencidas((int) $resultado['curso_id']);
            // Vuelve a leer por si el estado acaba de cambiar a "cerrada"
            $stmt->execute([$token]);
            $resultado = $stmt->fetch();
        }

        return $resultado ?: null;
    }

    /**
     * Se ejecuta en cada consulta relevante (en vez de depender solo del
     * event scheduler de MySQL, que en XAMPP viene apagado por defecto).
     * Marca como "ausente" a quien nunca envió el formulario después de
     * vencido el límite de tardanza, y cierra esas sesiones.
     */
    public static function cerrarVencidas(int $cursoId): void
    {
        $pdo = Database::obtenerConexion();

        $pdo->prepare(
            'INSERT INTO asistencias (sesion_id, estudiante_id, estado_asistencia, fecha_hora_registro)
             SELECT s.id, i.estudiante_id, "ausente", NULL
             FROM sesiones_clase s
             JOIN inscripciones i ON i.curso_id = s.curso_id AND i.estado = "activo"
             WHERE s.curso_id = ?
               AND TIMESTAMP(s.fecha, s.hora_limite_tardanza) < NOW()
               AND s.estado <> "cancelada"
               AND NOT EXISTS (
                   SELECT 1 FROM asistencias a WHERE a.sesion_id = s.id AND a.estudiante_id = i.estudiante_id
               )'
        )->execute([$cursoId]);

        $pdo->prepare(
            'UPDATE sesiones_clase
             SET estado = "cerrada"
             WHERE curso_id = ?
               AND TIMESTAMP(fecha, hora_limite_tardanza) < NOW()
               AND estado IN ("programada", "abierta")'
        )->execute([$cursoId]);
    }
}
