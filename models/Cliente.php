<?php
declare(strict_types=1);

class Cliente
{
    public int $id = 0;
    public string $nombre = '';
    public string $correo = '';
    public bool $activo = true;
    public ?string $telefono = null;

    public function __construct(private mysqli $conexion) {}

    // Asignación dinámica de campos mediante propiedades variables sobre lista blanca
    public function hidratar(array $datos): void
    {
        $propiedadesPermitidas = ['id', 'nombre', 'correo', 'activo', 'telefono'];
        foreach ($propiedadesPermitidas as $propiedad) {
            if (array_key_exists($propiedad, $datos)) {
                $this->$propiedad = $datos[$propiedad];
            }
        }
    }

    // CREATE
    public function guardar(): bool
    {
        $ejecutar = $this->conexion->prepare(
            'INSERT INTO clientes (nombre, correo, telefono, activo) VALUES (?, ?, ?, ?)'
        );
        $activoInt = $this->activo ? 1 : 0;
        $ejecutar->bind_param('sssi', $this->nombre, $this->correo, $this->telefono, $activoInt);
        return $ejecutar->execute();
    }

    // READ (General y búsqueda)
    public function listar(string $termino = ''): mysqli_result|bool
    {
        if ($termino !== '') {
            $ejecutar = $this->conexion->prepare(
                'SELECT * FROM clientes WHERE nombre LIKE ? OR correo LIKE ? ORDER BY id DESC'
            );
            $like = "%{$termino}%";
            $ejecutar->bind_param('ss', $like, $like);
            $ejecutar->execute();
            return $ejecutar->get_result();
        }

        return $this->conexion->query('SELECT * FROM clientes ORDER BY id DESC');
    }

    // READ (Individual por ID)
    public function consultar(int $id): ?array
    {
        $ejecutar = $this->conexion->prepare('SELECT * FROM clientes WHERE id = ?');
        $ejecutar->bind_param('i', $id);
        $ejecutar->execute();
        $resultado = $ejecutar->get_result();
        $fila = $resultado ? $resultado->fetch_assoc() : null;
        return $fila ?: null;
    }

    // UPDATE
    public function actualizar(): bool
    {
        $ejecutar = $this->conexion->prepare(
            'UPDATE clientes SET nombre = ?, correo = ?, telefono = ?, activo = ? WHERE id = ?'
        );
        $activoInt = $this->activo ? 1 : 0;
        $ejecutar->bind_param(
            'sssii',
            $this->nombre,
            $this->correo,
            $this->telefono,
            $activoInt,
            $this->id
        );
        return $ejecutar->execute();
    }

    // DELETE
    public function eliminar(int $id): bool
    {
        $ejecutar = $this->conexion->prepare('DELETE FROM clientes WHERE id = ?');
        $ejecutar->bind_param('i', $id);
        return $ejecutar->execute();
    }
}