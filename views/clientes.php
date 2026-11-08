<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - CRUD POO</title>
</head>
<body>
    <nav>
        <strong>Módulos:</strong>
        <a href="index.php?modulo=personas">Personas</a> |
        <a href="index.php?modulo=clientes"><b>[ Clientes (CRUD POO) ]</b></a>
    </nav>
    <hr>

    <h2><?= $clienteEditar ? 'Editar Cliente' : 'Registrar Cliente' ?></h2>

    <form method="POST" action="index.php?modulo=clientes">
        <input type="hidden" name="id" value="<?= (int) ($clienteEditar['id'] ?? 0) ?>">

        <label>Nombre:
            <input type="text" name="nombre" maxlength="80" required
                   value="<?= htmlspecialchars($clienteEditar['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                   placeholder="Ingrese el nombre">
        </label>
        <br><br>

        <label>Correo:
            <input type="email" name="correo" maxlength="100" required
                   value="<?= htmlspecialchars($clienteEditar['correo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                   placeholder="cliente@correo.com">
        </label>
        <br><br>

        <label>Teléfono:
            <input type="text" name="telefono" maxlength="20"
                   value="<?= htmlspecialchars($clienteEditar['telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                   placeholder="Opcional (ej. 0991234567)">
        </label>
        <br><br>

        <label>
            <input type="checkbox" name="activo" value="1"
                   <?= (!isset($clienteEditar) || (int) $clienteEditar['activo'] === 1) ? 'checked' : '' ?>>
            Activo
        </label>
        <br><br>

        <button type="submit"><?= $clienteEditar ? 'Actualizar Cliente' : 'Guardar Cliente' ?></button>
        <?php if ($clienteEditar): ?>
            <a href="index.php?modulo=clientes">Cancelar</a>
        <?php endif; ?>
    </form>

    <hr>

    <h3>Lista de Clientes Registrados</h3>
    <form method="GET" action="index.php">
        <input type="hidden" name="modulo" value="clientes">
        <input type="search" name="q" placeholder="Buscar por nombre o correo"
               value="<?= htmlspecialchars($q ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit">Buscar</button>
        <?php if (!empty($q)): ?>
            <a href="index.php?modulo=clientes">Limpiar</a>
        <?php endif; ?>
    </form>
    <br>

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $clientes->fetch_assoc()): ?>
                <tr>
                    <td><?= (int) $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($fila['correo'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($fila['telefono'] ?? 'Sin registro', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= ((int) $fila['activo'] === 1) ? 'Activo' : 'Inactivo' ?></td>
                    <td>
                        <a href="index.php?modulo=clientes&editar=<?= (int) $fila['id'] ?>">Editar</a> |
                        <a href="index.php?modulo=clientes&eliminar=<?= (int) $fila['id'] ?>"
                           onclick="return confirm('¿Confirmar eliminación del cliente?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>