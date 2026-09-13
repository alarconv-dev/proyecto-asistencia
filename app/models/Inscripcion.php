<?php

class Inscripcion
{
    // Si la inscripción ya existía pero estaba retirada, la reactiva.
    // Si no existía, la crea. Así nunca se duplica el par curso+estudiante.
    public static function inscribir(int $cursoId, int $estudianteId): void
    {
        $pdo = Database::obtenerConexion();

        $stmt = $pdo->prepare('SELECT id FROM inscripciones WHERE curso_id = ? AND estudiante_id = ?');
        $stmt->execute([$cursoId, $estudianteId]);
        $existente = $stmt->fetch();

        if ($existente) {
            $update = $pdo->prepare('UPDATE inscripciones SET estado = "activo" WHERE id = ?');
            $update->execute([$existente['id']]);
            return;
        }

        $insert = $pdo->prepare('INSERT INTO inscripciones (curso_id, estudiante_id) VALUES (?, ?)');
        $insert->execute([$cursoId, $estudianteId]);
    }

    // Borrado lógico: se marca como retirado, no se elimina la fila,
    // para no perder el historial de asistencia ya registrado.
    public static function retirar(int $cursoId, int $estudianteId): bool
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('UPDATE inscripciones SET estado = "retirado" WHERE curso_id = ? AND estudiante_id = ?');
        return $stmt->execute([$cursoId, $estudianteId]);
    }
}
