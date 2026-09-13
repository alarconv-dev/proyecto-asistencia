<?php

class SesionController
{
    public function __construct()
    {
        Auth::verificarLogin();
    }

    private function verificarCursoDelProfesor(int $cursoId): array
    {
        $curso = Curso::obtenerPorId($cursoId, Auth::profesorActualId());
        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado";
            exit;
        }
        return $curso;
    }

    public function mostrarCrear(int $cursoId): void
    {
        $curso = $this->verificarCursoDelProfesor($cursoId);
        require BASE_PATH . '/app/views/sesiones/crear.php';
    }

    public function crear(int $cursoId): void
    {
        $this->verificarCursoDelProfesor($cursoId);

        $datos = [
            'curso_id'               => $cursoId,
            'fecha'                  => $_POST['fecha'] ?? '',
            'hora_inicio'            => $_POST['hora_inicio'] ?? '',
            'hora_limite_asistencia' => $_POST['hora_limite_asistencia'] ?? '',
            'hora_limite_tardanza'   => $_POST['hora_limite_tardanza'] ?? '',
            'tema'                   => trim($_POST['tema'] ?? ''),
        ];

        $sesionId = SesionClase::crear($datos);

        header('Location: ' . BASE_URL . '/cursos/' . $cursoId . '/sesiones/' . $sesionId);
        exit;
    }

    public function detalle(int $cursoId, int $sesionId): void
    {
        $curso = $this->verificarCursoDelProfesor($cursoId);
        $sesion = SesionClase::obtenerPorId($sesionId, $cursoId);

        if (!$sesion) {
            http_response_code(404);
            echo "Sesión no encontrada";
            return;
        }

        $asistencias = Asistencia::obtenerPorSesion($sesionId);
        $enlaceFormulario = BASE_URL . '/asistencia/' . $sesion['token_formulario'];

        require BASE_PATH . '/app/views/sesiones/detalle.php';
    }
}
