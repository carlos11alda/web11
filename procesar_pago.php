<?php
session_start();
include 'config.php'; // Asegúrate de que config.php contenga la configuración de conexión correcta

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo 'Debes iniciar sesión para proceder con el pago. <a href="index.php">Regresar al inicio</a>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $name = $_POST['name'];
    $address = $_POST['address'];
    $card = $_POST['card'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];
    $payment_amount = $_POST['payment_amount']; // Nuevo campo

    // Validación y procesamiento del pago
    $pagoExitoso = true; // Supongamos que el pago fue exitoso

    if ($pagoExitoso) {
        // Insertar datos del pago en la base de datos
        $query = "INSERT INTO pagos (name, address, card_number, expiry_date, cvv, payment_amount) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssssd", $name, $address, $card, $expiry, $cvv, $payment_amount);

        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            // Reiniciar el carrito después del pago exitoso
            $_SESSION['cart'] = array(); // Vaciar el carrito en la sesión
            echo 'Pago procesado exitosamente. <a href="index.php">Regresar al inicio</a>';
        } else {
            echo 'Error al procesar el pago: ' . mysqli_stmt_error($stmt) . '. <a href="index.php">Regresar al inicio</a>';
        }

        // Cerrar statement
        mysqli_stmt_close($stmt);
    } else {
        echo 'Error al procesar el pago. <a href="index.php">Regresar al inicio</a>';
    }
} else {
    echo 'Método de solicitud no válido. <a href="index.php">Regresar al inicio</a>';
}

// Cerrar conexión
mysqli_close($conn);

exit;
?>
