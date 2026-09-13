<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h1 class="h4 mb-0 fw-bold">Nueva sesión - <?= htmlspecialchars($curso['nombre']) ?></h1>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= BASE_URL ?>/cursos/<?= $curso['id'] ?>/sesiones/crear">
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Fecha</label>
                                <input type="date" name="fecha" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold small">Tema (opcional)</label>
                                <input type="text" name="tema" class="form-control" placeholder="Ej. Introducción al curso, Práctica 1...">
                            </div>
                        </div>

                        <hr class="text-muted my-4">

                        <h2 class="h6 text-secondary fw-bold mb-3 text-uppercase tracking-wider">Control de Horarios</h2>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-success">Hora de inicio</label>
                                <input type="time" name="hora_inicio" class="form-control border-success-subtle" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-warning">Hora de tolerancia</label>
                                <input type="time" name="hora_limite_asistencia" class="form-control border-warning-subtle" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small text-danger">Fin de la clase</label>
                                <input type="time" name="hora_limite_tardanza" class="form-control border-danger-subtle" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2 border-top">
                            <a href="<?= BASE_URL ?>/cursos/detalle/<?= $curso['id'] ?>" class="btn btn-outline-secondary px-4 me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5 fw-semibold">Crear sesión</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>