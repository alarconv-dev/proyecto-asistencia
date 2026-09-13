<?php

class Asistencia
{
    public static function obtenerPorSesion(int $sesionId): array
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare(
            'SELECT a.*, e.nombres, e.apellidos, e.codigo_estudiante
             FROM asistencias a
             JOIN estudiantes e ON e.id = a.estudiante_id
             WHERE a.sesion_id = ?
             ORDER BY e.apellidos, e.nombres'
        );
        $stmt->execute([$sesionId]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public static function yaRegistrado(int $sesionId, int $estudianteId): bool
    {
        $pdo = Database::obtenerConexion();
        $stmt = $pdo->prepare('SELECT id FROM asistencias WHERE sesion_id = ? AND estudiante_id = ?');
        $stmt->execute([$sesionId, $estudianteId]);
        return (bool) $stmt->fetch();
    }

    // Lógica del trigger migrada a PHP con control de zona horaria americana/peruana
    public static function registrar(int $sesionId, int $estudianteId, string $ip, string $userAgent): bool
    {
        $pdo = Database::obtenerConexion();
        
        // 1. Obtener los límites de tiempo de la sesión
        $stmtSesion = $pdo->prepare('SELECT hora_limite_asistencia, hora_limite_tardanza FROM sesiones_clase WHERE id = ?');
        $stmtSesion->execute([$sesionId]);
        $sesion = $stmtSesion->fetch(PDO::FETCH_ASSOC);
        
        // 2. Definir hora actual en tu zona horaria real (America/Lima)
        $timezone = new DateTimeZone('America/Lima');
        $ahora = new DateTime();
        $ahora->setTimezone($timezone);
        
        $fechaHoraRegistro = $ahora->format('Y-m-d H:i:s');
        $horaRegistro = $ahora->format('H:i:s');
        
        $estadoAsistencia = 'ausente';
        
        if ($sesion) {
            $horaLimiteAsistencia = $sesion['hora_limite_asistencia'];
            $horaLimiteTardanza = $sesion['hora_limite_tardanza'];
            
            // 3. Evaluar el estado tal como lo hacía el Trigger
            if ($horaRegistro <= $horaLimiteAsistencia) {
                $estadoAsistencia = 'asistio';
            } elseif ($horaRegistro <= $horaLimiteTardanza) {
                $estadoAsistencia = 'tardanza';
            } else {
                $estadoAsistencia = 'ausente';
            }
        }

        // 4. Insertar registro con el estado calculado en PHP
        $stmt = $pdo->prepare(
            'INSERT INTO asistencias (sesion_id, estudiante_id, estado_asistencia, fecha_hora_registro, ip_registro, dispositivo)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        return $stmt->execute([$sesionId, $estudianteId, $estadoAsistencia, $fechaHoraRegistro, $ip, $userAgent]);
    }
}