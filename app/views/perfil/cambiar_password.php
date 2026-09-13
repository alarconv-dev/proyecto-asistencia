<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-dark text-white py-3">
                    <h1 class="h4 mb-0 fw-bold">Cambiar mi contraseña</h1>
                </div>
                <div class="card-body p-4">

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 px-3 small mb-3" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($exito)): ?>
                        <div class="alert alert-success py-2 px-3 small mb-3" role="alert">
                            <?= htmlspecialchars($exito) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= BASE_URL ?>/perfil/password">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Contraseña actual</label>
                            <input type="password" name="password_actual" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Nueva contraseña (mínimo 8 caracteres)</label>
                            <input type="password" name="password_nueva" class="form-control" required minlength="8">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Confirmar nueva contraseña</label>
                            <input type="password" name="password_confirmar" class="form-control" required minlength="8">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark fw-semibold">Actualizar contraseña</button>
                            <a href="<?= BASE_URL ?>/cursos" class="btn btn-outline-secondary">Volver al inicio</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>