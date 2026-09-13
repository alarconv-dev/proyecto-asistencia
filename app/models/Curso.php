<?php

/**
 * Modelo: toda la interacción con la tabla `cursos` vive aquí.
 * El controller nunca escribe SQL directamente, solo llama a estos métodos.
 */
class Curso
{
    public static function obtenerPorProfesor(int $profesorId): array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare(
            'SELECT * FROM cursos WHERE profesor_id = ? AND estado != "archivado" ORDER BY fecha_creacion DESC'
        );
        $stmt->execute([$profesorId]);
        return $stmt->fetchAll();
    }

    // Siempre se filtra también por profesor_id: así un profesor jamás
    // puede ver ni tocar un curso que no es suyo, aunque adivine el ID.
    public static function obtenerPorId(int $id, int $profesorId): ?array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('SELECT * FROM cursos WHERE id = ? AND profesor_id = ?');
        $stmt->execute([$id, $profesorId]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }

    public static function crear(array $datos): int
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare(
            'INSERT INTO cursos (profesor_id, nombre, codigo_curso, descripcion, periodo, tolerancia_tardanza_min)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $datos['profesor_id'],
            $datos['nombre'],
            $datos['codigo_curso'],
            $datos['descripcion'],
            $datos['periodo'],
            $datos['tolerancia_tardanza_min'],
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function actualizar(int $id, int $profesorId, array $datos): bool
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare(
            'UPDATE cursos SET nombre = ?, descripcion = ?, periodo = ?, tolerancia_tardanza_min = ?
             WHERE id = ? AND profesor_id = ?'
        );
        return $stmt->execute([
            $datos['nombre'],
            $datos['descripcion'],
            $datos['periodo'],
            $datos['tolerancia_tardanza_min'],
            $id,
            $profesorId,
        ]);
    }

    // Borrado lógico: no se elimina la fila, se archiva. Así no se pierden
    // los históricos de asistencia asociados al curso.
    public static function eliminar(int $id, int $profesorId): bool
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('UPDATE cursos SET estado = "archivado" WHERE id = ? AND profesor_id = ?');
        return $stmt->execute([$id, $profesorId]);
    }
}
