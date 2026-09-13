<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - Control de Asistencia</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- CSS original -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/estilos.css">

    <style>
        /* Fondo animado y reticular adaptado para el body */
        body {
            width: 100vw;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(
                to bottom,
                #fff 0%,
                #fff 40%,
                rgba(255, 255, 255, 0) 100%
            ),
            linear-gradient(to right, #0ed2da, #5f29c7);
            position: relative;
            overflow-x: hidden;
        }

        /* Capa con las líneas verticales y el desvanecido */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: linear-gradient(90deg, rgba(204, 204, 204, 0.6) 1px, transparent 1px);
            background-size: 50px 100%;
            pointer-events: none;
            z-index: 0;
            mask-image: linear-gradient(
                to bottom,
                rgba(0, 0, 0, 1) 0%,
                rgba(0, 0, 0, 0) 70%
            );
            -webkit-mask-image: linear-gradient(
                to bottom,
                rgba(0, 0, 0, 1) 0%,
                rgba(0, 0, 0, 0) 70%
            );
        }

        /* Asegura que la tarjeta quede por encima del pseudoelemento del fondo */
        main.contenedor {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <main class="contenedor contenedor-angosto p-4 p-sm-5 bg-white rounded-4 shadow" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <span class="brand-mark d-inline-flex justify-content-center align-items-center bg-primary-subtle text-primary rounded-circle" style="width:56px;height:56px;font-size:1.5rem;">
                <i class="bi bi-calendar2-check"></i>
            </span>
        </div>
        <h1 class="text-center h3 mb-4 fw-bold">Iniciar sesión</h1>

        <?php if (!empty($error)): ?>
            <p class="mensaje-error alert alert-danger p-2 text-center" role="alert"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/login">
            <div class="mb-3">
                <label class="form-label fw-semibold">Usuario</label>
                <input type="text" name="usuario" class="form-control" required autofocus>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary fw-bold">Entrar</button>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>