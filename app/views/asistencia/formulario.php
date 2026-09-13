<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marcar asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/estilos.css">
</head>
<body class="d-flex align-items-center min-vh-100">
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5 text-center">
                    
                    <h1 class="h3 mb-2 text-primary fw-bold">Marcar asistencia</h1>
                    <p class="text-muted mb-4">
                        <span class="fs-5 d-block text-dark fw-medium mb-1"><?= htmlspecialchars($sesion['curso_nombre']) ?></span>
                        <span class="badge bg-secondary-subtle text-secondary-emphasis px-3 py-2"><?= htmlspecialchars($sesion['fecha']) ?></span>
                    </p>

                    <?php if (!empty($error)): ?>
                        <p class="mensaje-error alert alert-danger py-2.5 px-3 small text-start mb-4" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </p>
                    <?php endif; ?>

                    <form method="POST" action="<?= BASE_URL ?>/asistencia/<?= htmlspecialchars($sesion['token_formulario']) ?>" class="text-start">
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small">Ingresa tu código de estudiante</label>
                            <input type="text" name="codigo_estudiante" class="form-control form-control-lg text-center font-monospace fs-4 py-2" placeholder="Código de alumno" required autofocus>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold py-2.5">Marcar asistencia</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>