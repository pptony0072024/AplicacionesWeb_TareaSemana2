<?php
declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/PersonasControllers.php';
require_once __DIR__ . '/controllers/ClientesControllers.php';

$modulo = $_GET['modulo'] ?? 'clientes';

if ($modulo === 'personas') {
    $controlador = new PersonaController($conexion);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controlador->guardar();
    } else {
        $controlador->index();
    }
} else {
    $controlador = new ClienteController($conexion);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controlador->guardar();
    } elseif (isset($_GET['eliminar'])) {
        $controlador->eliminar();
    } else {
        $controlador->index();
    }
}