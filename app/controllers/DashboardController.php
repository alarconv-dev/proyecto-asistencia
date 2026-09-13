<?php

class DashboardController
{
    public function __construct()
    {
        Auth::verificarLogin();
    }

    public function index(): void
    {
        $cursos = Curso::obtenerPorProfesor(Auth::profesorActualId());
        $totalCursos = count($cursos);
        require BASE_PATH . '/app/views/dashboard/index.php';
    }
}
