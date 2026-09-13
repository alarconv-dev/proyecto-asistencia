<?php

class Profesor
{
    public static function obtenerPorUsuario(string $usuario): ?array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('SELECT * FROM profesores WHERE usuario = ? AND estado = "activo"');
        $stmt->execute([$usuario]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }

    public static function obtenerPorId(int $id): ?array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('SELECT * FROM profesores WHERE id = ?');
        $stmt->execute([$id]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }

    public static function actualizarUltimoLogin(int $id): void
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('UPDATE profesores SET ultimo_login = NOW() WHERE id = ?');
        $stmt->execute([$id]);
    }

    // La contraseña llega en texto plano y aquí mismo se hashea antes de guardar.
    public static function crear(array $datos): int
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare(
            'INSERT INTO profesores (nombres, apellidos, correo, usuario, password_hash) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $datos['nombres'],
            $datos['apellidos'],
            $datos['correo'],
            $datos['usuario'],
            password_hash($datos['password'], PASSWORD_DEFAULT),
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function existeUsuarioOCorreo(string $usuario, string $correo): bool
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('SELECT id FROM profesores WHERE usuario = ? OR correo = ?');
        $stmt->execute([$usuario, $correo]);
        return (bool) $stmt->fetch();
    }

    public static function listarTodos(): array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->query('SELECT id, nombres, apellidos, usuario, correo, estado FROM profesores ORDER BY apellidos');
        return $stmt->fetchAll();
    }

    // Recibe la contraseña en texto plano y la hashea aquí antes de guardar.
    public static function actualizarPassword(int $id, string $nuevaPassword): bool
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('UPDATE profesores SET password_hash = ? WHERE id = ?');
        return $stmt->execute([password_hash($nuevaPassword, PASSWORD_DEFAULT), $id]);
    }
}
