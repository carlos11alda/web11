<?php
session_start();
include 'config.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Inicializar $user como un array vacío para evitar errores si no se encuentran datos
$user = array();
$error_message = '';
$success_message = '';

// Obtener los datos del usuario desde la base de datos
$user_id = $_SESSION['user_id'];
$query = "SELECT nombre, apellido, email, username FROM usuarios WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verificar si se obtuvieron resultados
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
}

// Procesar el formulario si se envió para actualizar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y actualizar nombre, apellido, email y username
    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['username'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $username = $_POST['username'];

        // Verificar si el nuevo username ya está en uso
        $check_username_query = "SELECT id FROM usuarios WHERE username = ? AND id != ?";
        $check_stmt = mysqli_prepare($conn, $check_username_query);
        mysqli_stmt_bind_param($check_stmt, "si", $username, $user_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $error_message = 'El nombre de usuario ya está en uso.';
        } else {
            // Actualizar los datos en la base de datos
            $update_query = "UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, username = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, "ssssi", $nombre, $apellido, $email, $username, $user_id);

            if (mysqli_stmt_execute($update_stmt)) {
                $success_message = 'Datos actualizados correctamente.';
                // Actualizar los datos en la sesión también
                $_SESSION['user_nombre'] = $nombre;
                $_SESSION['user_apellido'] = $apellido;
                $_SESSION['user_username'] = $username;
            } else {
                $error_message = 'Hubo un problema al actualizar los datos.';
            }

            mysqli_stmt_close($update_stmt);
        }

        mysqli_stmt_close($check_stmt);
    }
}

// Cerrar la consulta preparada
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <a href="index.php">Inicio</a>
            <a href="media.html">Videos</a>
            <a href="products.html">Productos</a>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="account.php">Mi Cuenta</a>
            <?php else : ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
            <a href="cart.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count">0</span>
            </a>
        </nav>
    </header>
    <div class="profile-container">
        <h1>Mi Cuenta</h1>
        <img src="imagenes/imange-usuario.jpg" alt="" height="150px">
        <div class="profile-details">
            <?php if (!empty($user)) : ?>
                <form action="account.php" method="post">
                    <p>Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required></p>
                    <p>Apellido: <input type="text" name="apellido" value="<?php echo htmlspecialchars($user['apellido']); ?>" required></p>
                    <p>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></p>
                    <p>Username: <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required></p>
                    <button type="submit">Guardar Cambios</button><br><br>
                </form>
                <?php if (!empty($error_message)) : ?>
                    <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <?php if (!empty($success_message)) : ?>
                    <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
                <?php endif; ?>
            <?php else : ?>
                <p>No se encontraron datos de usuario.</p>
            <?php endif; ?>
        </div>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</body>

</html>
