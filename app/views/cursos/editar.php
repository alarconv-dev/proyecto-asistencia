<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h1 class="h4 mb-0 py-1 fw-bold">Editar curso</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/cursos/editar/<?= $curso['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre del curso</label>
                            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($curso['nombre']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Periodo</label>
                            <input type="text" name="periodo" class="form-control" value="<?= htmlspecialchars($curso['periodo'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3"><?= htmlspecialchars($curso['descripcion'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tolerancia para tardanza (minutos)</label>
                            <input type="number" name="tolerancia_tardanza_min" class="form-control" value="<?= (int) $curso['tolerancia_tardanza_min'] ?>" min="0">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning fw-semibold">Guardar cambios</button>
                            <a href="<?= BASE_URL ?>/cursos" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>