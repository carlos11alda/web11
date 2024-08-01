<?php
session_start();
include 'config.php';

// Verificar si el usuario tiene permisos de administrador (rol = 1)
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 1) {
    header('Location: index.php');
    exit;
}

// Procesar el formulario si se envió para asignar rol de administrador o eliminar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;
        $payment_id = isset($_POST['payment_id']) ? (int)$_POST['payment_id'] : null;

        if ($_POST['action'] === 'assign_admin' && $user_id) {
            $query = "UPDATE usuarios SET rol = 1 WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            $success_message = mysqli_stmt_execute($stmt) ? 'Usuario ahora tiene rol de administrador.' : 'Hubo un problema al asignar el rol de administrador.';
            mysqli_stmt_close($stmt);
        } elseif ($_POST['action'] === 'remove_admin' && $user_id) {
            $query = "UPDATE usuarios SET rol = 0 WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            $success_message = mysqli_stmt_execute($stmt) ? 'Rol de administrador eliminado para el usuario.' : 'Hubo un problema al quitar el rol de administrador.';
            mysqli_stmt_close($stmt);
        } elseif ($_POST['action'] === 'delete_user' && $user_id) {
            $query = "DELETE FROM usuarios WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            $success_message = mysqli_stmt_execute($stmt) ? 'Usuario eliminado correctamente.' : 'Hubo un problema al eliminar el usuario.';
            mysqli_stmt_close($stmt);
        } elseif ($_POST['action'] === 'delete_payment' && $payment_id) {
            $query = "DELETE FROM pagos WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $payment_id);
            $success_message = mysqli_stmt_execute($stmt) ? 'Pago eliminado correctamente.' : 'Hubo un problema al eliminar el pago.';
            mysqli_stmt_close($stmt);
        }
    }
}

// Obtener la lista de usuarios
$query_usuarios = "SELECT id, nombre, email, rol FROM usuarios";
$result_usuarios = mysqli_query($conn, $query_usuarios);
$error_message_usuarios = $result_usuarios ? '' : 'Error en la base de datos al obtener usuarios.';

// Obtener la lista de pagos
$query_pagos = "SELECT id, name, address, card_number, expiry_date, cvv, payment_date, payment_amount FROM pagos";
$result_pagos = mysqli_query($conn, $query_pagos);
$error_message_pagos = $result_pagos ? '' : 'Error en la base de datos al obtener pagos.';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administrar Pagos y Usuarios</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos adicionales para la tabla y mensajes */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .container h1 {
            margin-bottom: 20px;
        }

        .container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .container th,
        .container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .container th {
            background-color: #f2f2f2;
        }

        .container .error {
            color: #ff0000;
            font-weight: bold;
            text-align: left;
        }

        .container .success {
            color: #00cc00;
            font-weight: bold;
            text-align: left;
        }

        .container form {
            display: inline-block;
        }

        .container form button {
            cursor: pointer;
        }

        .container .right-align {
            text-align: right;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar">
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="container">
        <h1>lista de Usuarios</h1>
        <?php if ($error_message_usuarios) : ?>
            <p class="error"><?php echo htmlspecialchars($error_message_usuarios); ?></p>
        <?php endif; ?>
        <?php if ($error_message_pagos) : ?>
            <p class="error"><?php echo htmlspecialchars($error_message_pagos); ?></p>
        <?php endif; ?>
        <?php if (isset($success_message)) : ?>
            <p class="success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <!-- Tabla de Usuarios -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_usuarios)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo ($row['rol'] == 1) ? 'Administrador' : 'Usuario Normal'; ?></td>
                        <td class="right-align">
                            <?php if ($row['rol'] == 0) : ?>
                                <form action="admin.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <input type="hidden" name="action" value="assign_admin">
                                    <button type="submit">Asignar como Administrador</button>
                                </form>
                            <?php elseif ($row['rol'] == 1) : ?>
                                <form action="admin.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <input type="hidden" name="action" value="remove_admin">
                                    <button type="submit">Quitar Rol de Administrador</button>
                                </form>
                            <?php endif; ?>
                            <form action="admin.php" method="post">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <input type="hidden" name="action" value="delete_user">
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar Usuario</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tabla de Pagos -->
        <h2>Lista de Pagos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Número de Tarjeta</th>
                    <th>Fecha de Vencimiento</th>
                    <th>CVV</th>
                    <th>Fecha de Pago</th>
                    <th>Monto de Pago</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_pagos)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['card_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['cvv']); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_amount']); ?></td>
                        <td class="right-align">
                            <form action="admin.php" method="post">
                                <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <input type="hidden" name="action" value="delete_payment">
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este pago?');">Eliminar Pago</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>