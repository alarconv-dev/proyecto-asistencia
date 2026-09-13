<?php

/**
 * Controller: recibe la petición, pide datos al Model, y los entrega a la View.
 * No contiene SQL ni HTML.
 */
class CursoController
{
    public function __construct()
    {
        // Todo este controller exige que haya un profesor logueado
        Auth::verificarLogin();
    }

    public function index(): void
    {
        $cursos = Curso::obtenerPorProfesor(Auth::profesorActualId());
        require BASE_PATH . '/app/views/cursos/index.php';
    }

    public function mostrarCrear(): void
    {
        require BASE_PATH . '/app/views/cursos/crear.php';
    }

    public function crear(): void
    {
        $datos = [
            'profesor_id'             => Auth::profesorActualId(),
            'nombre'                  => trim($_POST['nombre'] ?? ''),
            'codigo_curso'            => trim($_POST['codigo_curso'] ?? ''),
            'descripcion'             => trim($_POST['descripcion'] ?? ''),
            'periodo'                 => trim($_POST['periodo'] ?? ''),
            'tolerancia_tardanza_min' => (int) ($_POST['tolerancia_tardanza_min']),
        ];

        Curso::crear($datos);

        header('Location: ' . BASE_URL . '/cursos');
        exit;
    }

    public function mostrarEditar(int $id): void
    {
        $curso = Curso::obtenerPorId($id, Auth::profesorActualId());
        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado";
            return;
        }
        require BASE_PATH . '/app/views/cursos/editar.php';
    }

    public function editar(int $id): void
    {
        $datos = [
            'nombre'                  => trim($_POST['nombre'] ?? ''),
            'descripcion'             => trim($_POST['descripcion'] ?? ''),
            'periodo'                 => trim($_POST['periodo'] ?? ''),
            'tolerancia_tardanza_min' => (int) ($_POST['tolerancia_tardanza_min']),
        ];

        Curso::actualizar($id, Auth::profesorActualId(), $datos);

        header('Location: ' . BASE_URL . '/cursos');
        exit;
    }

    public function eliminar(int $id): void
    {
        Curso::eliminar($id, Auth::profesorActualId());
        header('Location: ' . BASE_URL . '/cursos');
        exit;
    }

    public function detalle(int $id): void
    {
        $curso = Curso::obtenerPorId($id, Auth::profesorActualId());
        if (!$curso) {
            http_response_code(404);
            echo "Curso no encontrado";
            return;
        }

        $estudiantes = Estudiante::obtenerPorCurso($id);
        $sesiones = SesionClase::obtenerPorCurso($id);

        require BASE_PATH . '/app/views/cursos/detalle.php';
    }
}
