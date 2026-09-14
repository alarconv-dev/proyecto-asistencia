<?php

// En Docker: http://localhost:8080  |  En XAMPP: http://localhost/proyecto-asistencia/public
define(
    'BASE_URL',
    getenv('BASE_URL') ?: 'http://localhost/proyecto-asistencia/public'
);
