<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">
    
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-4 bg-surface rounded">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="display-6 mb-2 text-dark fw-bold"><?= htmlspecialchars($curso['nombre']) ?></h1>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-secondary px-3 py-2">Código: <?= htmlspecialchars($curso['codigo_curso']) ?></span>
                        <span class="badge bg-dark px-3 py-2">Periodo: <?= htmlspecialchars($curso['periodo'] ?? '-') ?></span>
                        <span class="badge bg-info text-dark px-3 py-2">Tolerancia: <?= (int) $curso['tolerancia_tardanza_min'] ?> min</span>
                    </div>
                </div>
                <div>
                    <a href="<?= BASE_URL ?>/cursos/editar/<?= $curso['id'] ?>" class="btn btn-outline-primary">
                        <i class="bi bi-pencil"></i> Editar datos del curso
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-surface py-3">
                    <h2 class="h5 mb-0 text-secondary">
                        Estudiantes matriculados <span class="badge bg-primary rounded-pill ms-2"><?= count($estudiantes) ?></span>
                    </h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Código</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th class="text-end pe-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($estudiantes as $est): ?>
                                <tr>
                                    <td class="ps-3 font-monospace fw-bold text-muted"><?= htmlspecialchars($est['codigo_estudiante']) ?></td>
                                    <td><?= htmlspecialchars($est['nombres'] . ' ' . $est['apellidos']) ?></td>
                                    <td><?= htmlspecialchars($est['correo'] ?? '-') ?></td>
                                    <td class="text-end pe-3">
                                        <a href="<?= BASE_URL ?>/cursos/<?= $curso['id'] ?>/estudiantes/editar/<?= $est['id'] ?>" class="btn btn-sm btn-outline-secondary me-1">
                                            Editar
                                        </a>
                                        <form method="POST"
                                              action="<?= BASE_URL ?>/cursos/<?= $curso['id'] ?>/estudiantes/eliminar/<?= $est['id'] ?>"
                                              style="display:inline" onsubmit="return confirm('¿Quitar a este estudiante del curso?');">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Quitar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($estudiantes)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Aún no hay estudiantes en este curso.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-surface py-3">
                    <h3 class="h5 mb-0 text-secondary">Agregar estudiante</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/cursos/<?= $curso['id'] ?>/estudiantes/agregar">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Código del estudiante</label>
                            <input type="text" name="codigo_estudiante" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Nombres</label>
                            <input type="text" name="nombres" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Correo (opcional)</label>
                            <input type="email" name="correo" class="form-control">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-person-plus"></i> Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-surface py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="h5 mb-0 text-secondary">
                Sesiones de clase <span class="badge bg-primary rounded-pill ms-2"><?= count($sesiones) ?></span>
            </h2>
            <a href="<?= BASE_URL ?>/cursos/<?= $curso['id'] ?>/sesiones/crear" class="btn btn-sm btn-primary">
                + Nueva sesión
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Fecha</th>
                            <th>Hora inicio</th>
                            <th>Tema</th>
                            <th class="text-end pe-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sesiones as $ses): ?>
                        <tr>
                            <td class="ps-3">
                                <a href="<?= BASE_URL ?>/cursos/<?= $curso['id'] ?>/sesiones/<?= $ses['id'] ?>" class="text-decoration-none fw-semibold">
                                    <?= htmlspecialchars($ses['fecha']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($ses['hora_inicio']) ?></td>
                            <td><?= htmlspecialchars($ses['tema'] ?? '-') ?></td>
                            <td class="text-end pe-3">
                                <span class="badge bg-surface text-dark border">
                                    <?= htmlspecialchars($ses['estado']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($sesiones)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Aún no hay sesiones creadas.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>