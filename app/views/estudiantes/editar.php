<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-warning text-dark py-3">
                    <h1 class="h4 mb-0 fw-bold">Editar estudiante</h1>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= BASE_URL ?>/cursos/<?= $curso['id'] ?>/estudiantes/editar/<?= $estudiante['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted small">Código (no editable)</label>
                            <input type="text" value="<?= htmlspecialchars($estudiante['codigo_estudiante']) ?>" class="form-control bg-surface font-monospace text-secondary" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Nombres</label>
                            <input type="text" name="nombres" value="<?= htmlspecialchars($estudiante['nombres']) ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Apellidos</label>
                            <input type="text" name="apellidos" value="<?= htmlspecialchars($estudiante['apellidos']) ?>" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Correo</label>
                            <input type="email" name="correo" value="<?= htmlspecialchars($estudiante['correo'] ?? '') ?>" class="form-control">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning fw-semibold">Guardar cambios</button>
                            <a href="<?= BASE_URL ?>/cursos/detalle/<?= $curso['id'] ?>" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>