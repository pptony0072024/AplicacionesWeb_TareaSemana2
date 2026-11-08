<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Cliente.php';

class ClienteController
{
    private Cliente $modelo;

    public function __construct(mysqli $conexion)
    {
        $this->modelo = new Cliente($conexion);
    }

    public function index(): void
    {
        $clienteEditar = null;

        $idEditar = filter_input(INPUT_GET, 'editar', FILTER_VALIDATE_INT);
        if (is_int($idEditar) && $idEditar > 0) {
            $clienteEditar = $this->modelo->consultar($idEditar);
        }

        $q = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
        $clientes = $this->modelo->listar($q);

        require __DIR__ . '/../views/clientes.php';
    }

    public function guardar(): void
    {
        // Uso controlado de variables de variables (Semana 2 - Tema 1.3)
        $camposTexto = ['nombre', 'correo', 'telefono'];
        foreach ($camposTexto as $campo) {
            $valor = $_POST[$campo] ?? '';
            $$campo = is_string($valor) ? trim($valor) : '';
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: 0;
        $correoValido = filter_var($correo, FILTER_VALIDATE_EMAIL);
        $activo = isset($_POST['activo']);

        if ($nombre !== '' && mb_strlen($nombre) <= 80 && $correoValido !== false) {
            $this->modelo->hidratar([
                'id'       => (int) $id,
                'nombre'   => $nombre,
                'correo'   => (string) $correoValido,
                'telefono' => $telefono !== '' ? $telefono : null,
                'activo'   => $activo,
            ]);

            if ($this->modelo->id > 0) {
                $this->modelo->actualizar();
            } else {
                $this->modelo->guardar();
            }
        }

        header('Location: index.php?modulo=clientes');
        exit;
    }

    public function eliminar(): void
    {
        $idEliminar = filter_input(INPUT_GET, 'eliminar', FILTER_VALIDATE_INT);
        if (is_int($idEliminar) && $idEliminar > 0) {
            $this->modelo->eliminar($idEliminar);
        }

        header('Location: index.php?modulo=clientes');
        exit;
    }
}