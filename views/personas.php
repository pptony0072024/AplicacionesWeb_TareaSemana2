<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personas</title>
</head>
<body>
    <nav>
        <strong>Módulos:</strong>
        <a href="index.php?modulo=personas"><b>[ Personas ]</b></a> |
        <a href="index.php?modulo=clientes">Clientes (CRUD POO)</a>
    </nav>
    <hr>

    <h2>Guardar Persona</h2>
    <form method="POST" action="index.php?modulo=personas">
        <input type="text" name="nombre" placeholder="Ingrese su Nombre" required>
        <button type="submit">Guardar</button>
    </form>

    <h3>Lista de Personas registradas</h3>
    <ul>
        <?php while ($fila = $personas->fetch_assoc()): ?>
            <li><?= htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8') ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>