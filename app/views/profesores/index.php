<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h2 text-dark fw-bold mb-0">Profesores del sistema</h1>
            <p class="text-muted mb-0">Listado de docentes autorizados y su estado actual en la plataforma</p>
        </div>
        <a href="<?= BASE_URL ?>/profesores/crear" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
            <span>+ Registrar profesor</span>
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Nombre Completo</th>
                            <th class="py-3">Usuario</th>
                            <th class="py-3">Correo Electrónico</th>
                            <th class="pe-4 py-3 text-end">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($profesores as $p): ?>
                        <tr>
                            <td class="ps-4 fw-semibold text-dark">
                                <?= htmlspecialchars($p['nombres'] . ' ' . $p['apellidos']) ?>
                            </td>
                            <td>
                                <span class="badge bg-surface text-dark border font-monospace">
                                    <?= htmlspecialchars($p['usuario']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="mailto:<?= htmlspecialchars($p['correo']) ?>" class="text-decoration-none text-muted">
                                    <?= htmlspecialchars($p['correo']) ?>
                                </a>
                            </td>
                            <td class="pe-4 text-end">
                                <?php 
                                // Opcional: una pequeña lógica visual para el estado del profesor
                                $estado = strtolower($p['estado']);
                                $badgeClass = 'bg-secondary';
                                if ($estado === 'activo' || $estado === 'active' || $estado === '1') {
                                    $badgeClass = 'bg-success-subtle text-success-emphasis border border-success-subtle';
                                } elseif ($estado === 'inactivo' || $estado === 'inactive' || $estado === '0') {
                                    $badgeClass = 'bg-danger-subtle text-danger-emphasis border border-danger-subtle';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?> px-2.5 py-1.5 rounded text-capitalize">
                                    <?= htmlspecialchars($p['estado']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($profesores)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <p class="mb-0 fs-5 text-secondary fw-semibold">No hay profesores registrados</p>
                                    <p class="text-muted small">Haz clic en "+ Registrar profesor" para añadir uno nuevo.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>