<?php

class IntentoLogin
{
    public static function registrar(string $usuario, string $ip, bool $exitoso): void
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('INSERT INTO intentos_login (usuario, ip, exitoso) VALUES (?, ?, ?)');
        $stmt->execute([$usuario, $ip, $exitoso ? 1 : 0]);
    }

    // Cuenta los intentos fallidos de ese usuario+IP en los últimos 15 minutos
    public static function contarFallidosRecientes(string $usuario, string $ip): int
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare(
            'SELECT COUNT(*) AS total FROM intentos_login
             WHERE usuario = ? AND ip = ? AND exitoso = 0 AND fecha_creacion > (NOW() - INTERVAL 15 MINUTE)'
        );
        $stmt->execute([$usuario, $ip]);
        return (int) $stmt->fetch()['total'];
    }
}
