<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificar si el correo electrónico ya está registrado
    $sql_check = "SELECT * FROM usuarios WHERE email = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "El correo electrónico '$email' ya está registrado.";
    } else {
        // Insertar nuevo usuario con rol por defecto (usuario normal)
        $sql_insert = "INSERT INTO usuarios (nombre, apellido, email, username, password, rol) VALUES ('$nombre', '$apellido', '$email', '$username', '$password', 0)";

        if ($conn->query($sql_insert) === TRUE) {
            echo "¡Registro exitoso!";
            header("Location: login.php"); // Redirigir a la página de inicio de sesión
            exit();
        } else {
            echo "Error al registrar: " . $conn->error;
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="header">
        <h1>Registro</h1>
    </div>
    <div class="container">
        <div class="login-form">
            <form action="register.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Registrarse</button>
                <p>¿Si ya tienes cuenta?<a href="login.php">incia sesion</a></p>
            </form>
        </div>
    </div>
    <footer>
        <p>Contacto: <a href="mailto:correo@ejemplo.com">correo@ejemplo.com</a> | Tel: 123-456-7890</p>
        <p>Síguenos:
            <a href="#">Facebook</a> |
            <a href="#">Twitter</a> |
            <a href="#">Instagram</a>
        </p>
    </footer>
</body>

</html>