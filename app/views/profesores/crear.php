<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h1 class="h4 mb-0 fw-bold">Registrar profesor</h1>
                </div>
                <div class="card-body p-4">

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 px-3 small mb-3" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= BASE_URL ?>/profesores/crear">
                        
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-semibold small">Nombres</label>
                                <input type="text" name="nombres" class="form-control" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-semibold small">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Correo</label>
                            <input type="email" name="correo" class="form-control" placeholder="ejemplo@correo.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Usuario (para iniciar sesión)</label>
                            <input type="text" name="usuario" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Contraseña (mínimo 8 caracteres)</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Confirmar contraseña</label>
                            <input type="password" name="password_confirmar" class="form-control" required minlength="8">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-semibold">Registrar</button>
                            <a href="<?= BASE_URL ?>/cursos" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>