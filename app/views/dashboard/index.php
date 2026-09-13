<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            <div class="card shadow border-0 rounded-4 overflow-hidden mb-4">
                <div class="card-body p-4 p-sm-5 bg-gradient bg-primary text-white position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8 text-center text-md-start">
                            <span class="badge bg-surface text-primary mb-2 px-3 py-1.5 fw-semibold text-uppercase tracking-wider">Panel de Control</span>
                            <h1 class="display-6 fw-bold mb-3">
                                Bienvenido, <?= htmlspecialchars(Auth::profesorActualNombre()) ?>
                            </h1>
                            <p class="lead mb-4 mb-md-0 opacity-90">
                                Gestiona tus cursos, estudiantes y toma asistencia de forma rápida y sencilla.
                            </p>
                        </div>
                        <div class="col-md-4 text-center d-none d-md-block">
                            <i class="bi bi-person-workspace" style="font-size: 5.5rem; opacity: 0.15;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary-subtle text-primary p-3 rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <span class="fs-2 fw-bold"><?= $totalCursos ?></span>
                            </div>
                            <div>
                                <h2 class="h5 mb-1 text-dark fw-bold">Cursos Asignados</h2>
                                <p class="text-muted small mb-0">Tienes <strong><?= $totalCursos ?></strong> curso(s) registrado(s) en este ciclo.</p>
                            </div>
                        </div>
                        <div>
                            <a href="<?= BASE_URL ?>/cursos" class="btn btn-primary btn-lg px-4 fw-semibold shadow-sm">
                                Ver mis cursos <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>