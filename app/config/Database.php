<?php
class Database
{
    private static ?PDO $conexion = null;

    public static function obtenerConexion(): PDO
    {
        if (self::$conexion === null) {
            $host    = 'localhost';
            $db      = 'control_asistencia';
            $usuario = 'root';   
            $clave   = '';       
            $charset = 'utf8mb4';

            $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false, // usa prepared statements reales (más seguro)
            ];

            self::$conexion = new PDO($dsn, $usuario, $clave, $opciones);
        }

        return self::$conexion;
    }
}
