<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <a href="index.php">Inicio</a>
            <a href="media.html">Videos</a>
            <a href="products.html">Productos</a>
            <a href="account.php">Mi Cuenta</a>
            <a href="cart.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count">0</span>
            </a>
        </nav>
    </header>
    <div class="header">
        <h1>Carrito de Compras</h1>
    </div>
    <div class="container">
        <div id="cart" class="cart">
            <h2>Carrito de Compras</h2>
            <ul id="cart-items"></ul>
            <p>Total: $<span id="cart-total">0.00</span></p>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <button onclick="showPaymentForm()">Proceder al Pago</button>
            <?php else : ?>
                <p>Debes iniciar sesión para proceder con el pago.</p>
            <?php endif; ?>
        </div>
        <div id="payment-form" style="display: none;">
            <h2>Formulario de Pago</h2>
            <form id="payment" method="POST" onsubmit="procesarPago(event)">
                <input type="text" name="name" placeholder="Nombre" required>
                <input type="text" name="address" placeholder="Dirección" required>
                <input type="text" name="card" placeholder="Número de tarjeta" required>
                <input type="text" name="expiry" placeholder="Fecha de vencimiento" required>
                <input type="text" name="cvv" placeholder="CVV" required>
                <input type="number" step="0.01" name="payment_amount" id="payment_amount" placeholder="Monto del pago" required readonly> <!-- Nuevo campo -->
                <button type="submit">Pagar</button>
            </form>
            <p id="payment-message"></p>
        </div>
    </div>
    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

        function renderCart() {
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');

            cartItems.innerHTML = '';
            let total = 0;

            cart.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.product} - $${item.price} x ${item.quantity}`;
                const removeButton = document.createElement('button');
                removeButton.textContent = 'Eliminar';
                removeButton.onclick = () => removeFromCart(item.product);
                li.appendChild(removeButton);
                cartItems.appendChild(li);
                total += item.price * item.quantity;
            });

            cartTotal.textContent = total.toFixed(2);
        }

        function removeFromCart(product) {
            cart = cart.filter(item => item.product !== product);
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
            updateCartCount();
        }

        function showPaymentForm() {
            if (isLoggedIn) {
                const paymentForm = document.getElementById('payment-form');
                const paymentAmountField = document.getElementById('payment_amount');
                const cartTotal = document.getElementById('cart-total').textContent;

                paymentAmountField.value = cartTotal;
                paymentForm.style.display = 'block';
            } else {
                alert('Debes iniciar sesión para proceder con el pago.');
            }
        }

        function procesarPago(event) {
            event.preventDefault();
            if (!isLoggedIn) {
                alert('Debes iniciar sesión para proceder con el pago.');
                return;
            }

            const form = document.getElementById('payment');
            const formData = new FormData(form);

            fetch('procesar_pago.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    const messageElement = document.getElementById('payment-message');
                    messageElement.innerHTML = data;

                    if (data.includes('Pago procesado exitosamente')) {
                        cart = [];
                        localStorage.removeItem('cart');
                        renderCart();
                        updateCartCount();
                    }
                })
                .catch(error => {
                    const messageElement = document.getElementById('payment-message');
                    messageElement.textContent = 'Ocurrió un error al procesar el pago.';
                });
        }

        function updateCartCount() {
            const cartCount = document.getElementById('cart-count');
            cartCount.textContent = cart.reduce((acc, item) => acc + item.quantity, 0);
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
            renderCart();
        });
    </script>
</body>

</html>
