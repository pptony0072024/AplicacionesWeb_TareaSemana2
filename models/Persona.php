<?php
class Persona {
    public function __construct(private mysqli $conexion) {}

    public function guardar($nombre): bool {
        $ejecutar = $this->conexion->prepare('insert into personas(nombre) values(?)');
        $ejecutar->bind_param('s', $nombre);
        return $ejecutar->execute();
    }

    public function listar(): mysqli_result|bool {
        return $this->conexion->query(
            "SELECT * FROM personas"
        );
    }
}