<?php

class EstudianteController
{
    public function __construct()
    {
        Auth::verificarLogin();
    }

    // Confirma que el curso exista Y pertenezca al profesor logueado.
    // Se usa en cada método para que nadie manipule estudiantes de un curso ajeno.
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

    public function agregar(int $cursoId): void
    {
        $this->verificarCursoDelProfesor($cursoId);

        $datos = [
            'codigo_estudiante' => trim($_POST['codigo_estudiante'] ?? ''),
            'nombres'           => trim($_POST['nombres'] ?? ''),
            'apellidos'         => trim($_POST['apellidos'] ?? ''),
            'correo'            => trim($_POST['correo'] ?? ''),
        ];

        if ($datos['codigo_estudiante'] === '' || $datos['nombres'] === '' || $datos['apellidos'] === '') {
            header('Location: ' . BASE_URL . '/cursos/detalle/' . $cursoId);
            exit;
        }

        $estudianteId = Estudiante::crearOEncontrar($datos);
        Inscripcion::inscribir($cursoId, $estudianteId);

        header('Location: ' . BASE_URL . '/cursos/detalle/' . $cursoId);
        exit;
    }

    public function eliminar(int $cursoId, int $estudianteId): void
    {
        $this->verificarCursoDelProfesor($cursoId);
        Inscripcion::retirar($cursoId, $estudianteId);
        header('Location: ' . BASE_URL . '/cursos/detalle/' . $cursoId);
        exit;
    }

    public function mostrarEditar(int $cursoId, int $estudianteId): void
    {
        $curso = $this->verificarCursoDelProfesor($cursoId);
        $estudiante = Estudiante::obtenerPorId($estudianteId);

        if (!$estudiante) {
            http_response_code(404);
            echo "Estudiante no encontrado";
            return;
        }

        require BASE_PATH . '/app/views/estudiantes/editar.php';
    }

    public function editar(int $cursoId, int $estudianteId): void
    {
        $this->verificarCursoDelProfesor($cursoId);

        $datos = [
            'nombres'   => trim($_POST['nombres'] ?? ''),
            'apellidos' => trim($_POST['apellidos'] ?? ''),
            'correo'    => trim($_POST['correo'] ?? ''),
        ];

        Estudiante::actualizar($estudianteId, $datos);

        header('Location: ' . BASE_URL . '/cursos/detalle/' . $cursoId);
        exit;
    }
}
