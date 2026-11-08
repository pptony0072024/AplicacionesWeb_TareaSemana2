<?php
$conexion = new mysqli('localhost', 'root', 'root', 'sexto');

if ($conexion->connect_error) {
    die('Error al conectar con la base de datos' . $conexion->connect_error);
}

$conexion->set_charset('utf8mb4');