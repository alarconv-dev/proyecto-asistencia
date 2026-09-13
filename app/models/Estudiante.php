<?php
class Estudiante
{
    public static function obtenerPorCurso(int $cursoId): array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare(
            'SELECT e.*
             FROM estudiantes e
             JOIN inscripciones i ON i.estudiante_id = e.id
             WHERE i.curso_id = ? AND i.estado = "activo"
             ORDER BY e.apellidos, e.nombres'
        );
        $stmt->execute([$cursoId]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public static function obtenerPorCodigo(string $codigo): ?array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('SELECT * FROM estudiantes WHERE codigo_estudiante = ?');
        $stmt->execute([$codigo]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    public static function obtenerPorId(int $id): ?array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('SELECT * FROM estudiantes WHERE id = ?');
        $stmt->execute([$id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    public static function crearOEncontrar(array $datos): int
    {
        $existente = self::obtenerPorCodigo($datos['codigo_estudiante']);
        if ($existente) {
            return (int) $existente['id'];
        }

        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare(
            'INSERT INTO estudiantes (codigo_estudiante, nombres, apellidos, correo) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([
            $datos['codigo_estudiante'],
            $datos['nombres'],
            $datos['apellidos'],
            $datos['correo'] !== '' ? $datos['correo'] : null,
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function actualizar(int $id, array $datos): bool
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('UPDATE estudiantes SET nombres = ?, apellidos = ?, correo = ? WHERE id = ?');
        return $stmt->execute([
            $datos['nombres'],
            $datos['apellidos'],
            $datos['correo'] !== '' ? $datos['correo'] : null,
            $id,
        ]);
    }
}