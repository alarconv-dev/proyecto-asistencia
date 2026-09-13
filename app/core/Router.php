<?php

/**
 * Router simple basado en expresiones regulares.
 * Soporta parámetros dinámicos con la sintaxis {nombre}, ej: /cursos/editar/{id}
 */
class Router
{
    private array $rutas = [];

    public function get(string $ruta, string $controller, string $metodo): void
    {
        $this->agregar('GET', $ruta, $controller, $metodo);
    }

    public function post(string $ruta, string $controller, string $metodo): void
    {
        $this->agregar('POST', $ruta, $controller, $metodo);
    }

    private function agregar(string $verbo, string $ruta, string $controller, string $metodo): void
    {
        // Convierte /cursos/editar/{id} en un patrón regex: /cursos/editar/([^/]+)
        $patron = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $ruta);
        $patron = '#^' . $patron . '$#';

        $this->rutas[] = [
            'verbo'      => $verbo,
            'patron'     => $patron,
            'controller' => $controller,
            'metodo'     => $metodo,
        ];
    }

    /**
     * Busca una ruta que coincida con la URI y el verbo HTTP actuales,
     * y ejecuta el controller/método correspondiente.
     */
    public function despachar(string $uriActual, string $verboActual): void
    {
        foreach ($this->rutas as $ruta) {
            if ($ruta['verbo'] !== $verboActual) {
                continue;
            }

            if (preg_match($ruta['patron'], $uriActual, $coincidencias)) {
                array_shift($coincidencias); // quita la coincidencia completa, deja solo los parámetros

                $controllerClase = $ruta['controller'];

                if (!class_exists($controllerClase)) {
                    http_response_code(500);
                    echo "Error: el controller {$controllerClase} no existe.";
                    return;
                }

                $controller = new $controllerClase();
                call_user_func_array([$controller, $ruta['metodo']], $coincidencias);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Página no encontrada";
    }
}
