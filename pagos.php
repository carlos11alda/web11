<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $payment_amount = $_POST['payment_amount']; // Nuevo campo

    // Validar y sanitizar los datos antes de almacenarlos en la base de datos

    // Insertar el pago en la tabla pagos
    $query = "INSERT INTO pagos (name, address, card_number, expiry_date, cvv, payment_amount) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssd", $name, $address, $card_number, $expiry_date, $cvv, $payment_amount);

    if (mysqli_stmt_execute($stmt)) {
        // Pago registrado exitosamente
        $success_message = '¡Pago procesado exitosamente!';
    } else {
        // Error al registrar el pago
        $error_message = 'Error al procesar el pago: ' . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

