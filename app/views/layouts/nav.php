<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>/">
            <span class="brand-mark"><i class="bi bi-calendar2-check"></i></span>
            <span>Control de Asistencia</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/cursos">Mis cursos</a>
                </li>
                
                <!-- CAMBIO CLAVE: Solo el administrador verá esta opción -->
                <?php if (Auth::esAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/profesores">Profesores</a>
                    </li>
                <?php endif; ?>
            </ul>
            
            <?php if (Auth::profesorActualId()): ?>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!-- Nombre del usuario -->
                    <div class="d-inline-flex align-items-center gap-1 px-2 py-1">
                        <span class="text-muted-light small">Hola,</span> 
                        <strong class="text-white"><?= htmlspecialchars(Auth::profesorActualNombre()) ?></strong>
                    </div>

                    <!-- Separador visual opcional -->
                    <div class="vr text-light opacity-50 mx-1"></div>

                    <!-- Enlace de Cambiar contraseña -->
                    <a class="btn btn-outline-light btn-sm d-inline-flex align-items-center gap-1" href="<?= BASE_URL ?>/perfil/password">
                        <i class="bi bi-shield-lock text-secondary"></i>
                        <span>Cambiar contraseña</span>
                    </a>

                    <!-- Enlace de Cerrar sesión -->
                    <a class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1" href="<?= BASE_URL ?>/logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Cerrar sesión</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>