<?php
session_start();
include 'config.php';

$error_message = ''; // Inicializar variable de mensaje de error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        $error_message = 'Por favor complete todos los campos';
    } else {
        // Preparar la consulta para obtener el usuario por email
        $query = "SELECT id, email, password, rol FROM usuarios WHERE email = ?";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            // Verificar si el usuario existe y la contraseña es correcta
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['rol']; // Guardar el rol en la sesión

                if ($user['rol'] == 1) {
                    // Es administrador
                    header('Location: admin.php');
                } else {
                    // Es usuario normal
                    header('Location: index.php');
                }
                exit;
            } else {
                $error_message = 'Email o contraseña incorrectos';
            }

            mysqli_stmt_close($stmt);
        } else {
            $error_message = 'Error en la base de datos';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="index.php">Inicio</a>
            <a href="register.php">Registro</a>
        </nav>
    </header>
    <div class="container">
        <div class="login-form">
            <h1>Inicio de Sesión</h1>
            <?php if (!empty($error_message)) : ?>
                <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label><br>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
