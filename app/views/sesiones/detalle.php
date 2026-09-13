<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-4 bg-surface rounded">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <span class="text-uppercase text-primary fw-bold tracking-wider small">Sesión de Clase</span>
                    <h1 class="display-6 mb-2 text-dark fw-bold">Fecha: <?= htmlspecialchars($sesion['fecha']) ?></h1>
                    <p class="lead mb-0 text-secondary">
                        Curso: <span class="fw-semibold text-dark"><?= htmlspecialchars($curso['nombre']) ?></span>
                    </p>
                </div>
                <div>
                    <?php 
                    $estadoSesion = strtolower($sesion['estado']);
                    $badgeSesion = 'bg-secondary';
                    if ($estadoSesion === 'activa' || $estadoSesion === 'activo' || $estadoSesion === 'abierta') {
                        $badgeSesion = 'bg-success';
                    } elseif ($estadoSesion === 'cerrada' || $estadoSesion === 'finalizada') {
                        $badgeSesion = 'bg-danger';
                    }
                    ?>
                    <span class="badge <?= $badgeSesion ?> px-4 py-2.5 fs-6 text-uppercase shadow-sm">
                        <?= htmlspecialchars($sesion['estado']) ?>
                    </span>
                </div>
            </div>

            <hr class="my-3 text-muted">

            <div class="row g-3">
                <div class="col-sm-6 col-md-4">
                    <div class="p-2 border-start border-success border-3 bg-surface rounded shadow-xs">
                        <span class="text-muted small d-block">Asistencia a tiempo</span>
                        <strong class="text-success"><?= htmlspecialchars($sesion['hora_limite_asistencia']) ?></strong>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="p-2 border-start border-warning border-3 bg-surface rounded shadow-xs">
                        <span class="text-muted small d-block">Tardanza permitida</span>
                        <strong class="text-warning"><?= htmlspecialchars($sesion['hora_limite_tardanza']) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-7 d-flex align-items-stretch">
            <div class="card shadow-sm border-0 w-100 bg-primary-subtle text-primary-emphasis">
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <h3 class="h5 fw-bold mb-3">
                        <i class="bi bi-link-45deg"></i> Enlace para estudiantes
                    </h3>
                    <p class="small mb-3">Comparte este enlace directo con tu clase para que puedan registrar su asistencia de forma inmediata:</p>
                    <div class="input-group">
                        <input type="text" class="form-control border-primary-subtle font-monospace text-truncate" value="<?= htmlspecialchars($enlaceFormulario) ?>" readonly id="inputEnlace">
                        <a href="<?= htmlspecialchars($enlaceFormulario) ?>" target="_blank" class="btn btn-primary px-3">
                            Abrir enlace
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4 text-center d-flex flex-column align-items-center justify-content-center">
                    <h3 class="h6 fw-bold text-secondary mb-3">Código QR de la Sesión</h3>
                    
                    <div class="p-3 bg-surface border rounded-3 shadow-xs mb-2 d-inline-block">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($enlaceFormulario) ?>"
                             alt="QR para marcar asistencia" class="img-fluid rounded" width="180" height="180">
                    </div>
                    
                    <span class="text-muted small">Los alumnos pueden escanearlo para ingresar</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-surface py-3 d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0 text-secondary">
                Asistencia registrada <span class="badge bg-primary rounded-pill ms-2"><?= count($asistencias) ?></span>
            </h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Código</th>
                            <th class="py-3">Estudiante</th>
                            <th class="py-3">Estado</th>
                            <th class="pe-4 py-3 text-end">Hora de registro</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($asistencias as $a): ?>
                        <tr>
                            <td class="ps-4 font-monospace fw-bold text-muted"><?= htmlspecialchars($a['codigo_estudiante']) ?></td>
                            <td><?= htmlspecialchars($a['nombres'] . ' ' . $a['apellidos']) ?></td>
                            <td>
                                <?php 
                                $estadoEst = strtolower($a['estado_asistencia']);
                                $badgeEst = 'bg-secondary';
                                if ($estadoEst === 'asistió' || $estadoEst === 'presente' || $estadoEst === 'asistio') {
                                    $badgeEst = 'bg-success-subtle text-success-emphasis border border-success-subtle';
                                } elseif ($estadoEst === 'tardanza') {
                                    $badgeEst = 'bg-warning-subtle text-warning-emphasis border border-warning-subtle';
                                } elseif ($estadoEst === 'falta' || $estadoEst === 'ausente') {
                                    $badgeEst = 'bg-danger-subtle text-danger-emphasis border border-danger-subtle';
                                }
                                ?>
                                <span class="badge <?= $badgeEst ?> px-2.5 py-1.5 rounded">
                                    <?= htmlspecialchars(ucfirst($a['estado_asistencia'])) ?>
                                </span>
                            </td>
                            <td class="pe-4 text-end text-muted font-monospace small">
                                <?= htmlspecialchars($a['fecha_hora_registro'] ?? '-') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($asistencias)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <p class="mb-0 fs-5 text-secondary fw-semibold">Todavía nadie ha marcado asistencia en esta sesión.</p>
                                    <p class="text-muted small">Los alumnos que usen el enlace o escaneen el QR aparecerán aquí automáticamente.</p>
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