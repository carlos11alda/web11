<?php
session_start();
include 'config.php';

// Verificar si el usuario tiene sesión iniciada
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Obtener la lista de productos
$query = "SELECT id, nombre, descripcion, precio FROM productos";
$result = mysqli_query($conn, $query);

if (!$result) {
    $error_message = 'Error en la base de datos al obtener productos.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="index.php">Inicio</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <div class="container">
        <h1>Lista de Productos</h1>
        <?php if (isset($error_message)) : ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($row['precio']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
