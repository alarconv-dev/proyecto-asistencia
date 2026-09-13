<?php require BASE_PATH . '/app/views/layouts/header.php'; ?>

<div class="container my-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h2 text-dark fw-bold mb-0">Mis cursos</h1>
            <p class="text-muted mb-0">Administra y organiza tus materias asignadas</p>
        </div>
        <a href="<?= BASE_URL ?>/cursos/crear" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
            <span>+ Nuevo curso</span>
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Nombre</th>
                            <th class="py-3">Código</th>
                            <th class="py-3">Periodo</th>
                            <th class="text-end pe-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td class="ps-4">
                                <a href="<?= BASE_URL ?>/cursos/detalle/<?= $curso['id'] ?>" class="text-decoration-none fw-semibold text-primary">
                                    <?= htmlspecialchars($curso['nombre']) ?>
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle px-2.5 py-1.5 rounded">
                                    <?= htmlspecialchars($curso['codigo_curso']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="text-muted fw-medium"><?= htmlspecialchars($curso['periodo'] ?? '-') ?></span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2">
                                    <a href="<?= BASE_URL ?>/cursos/editar/<?= $curso['id'] ?>" class="btn btn-sm btn-outline-secondary">
                                        Editar
                                    </a>
                                    <form method="POST" action="<?= BASE_URL ?>/cursos/eliminar/<?= $curso['id'] ?>"
                                          style="display:inline" onsubmit="return confirm('¿Eliminar este curso?');">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($cursos)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <div class="py-3">
                                    <p class="mb-0 fs-5 text-secondary fw-semibold">Aún no tienes cursos creados</p>
                                    <p class="text-muted small">Haz clic en "+ Nuevo curso" para empezar a registrar.</p>
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