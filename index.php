<?php
session_start();

$is_logged_in = isset($_SESSION['role']); // Verifica si hay una sesión activa

if ($is_logged_in && $_SESSION['role'] == 'admin') {
    header('Location: admin.php'); // Redirige al administrador a la página de administrador
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <a href="index.php">Inicio</a>
            <a href="media.html">Videos</a>
            <a href="products.html">Productos</a>
            <?php if (!$is_logged_in): ?>
                <a href="account.php" id="mi-cuenta">Mi Cuenta</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>

            <a href="cart.php" class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count">0</span>
            </a>
        </nav>
    </header>
    <div class="header">
        <h1>Tienda de Electrodomésticos</h1>
    </div>
    <div id="carousel" class="carousel">
        <img src="imagenes/imagen.jpg" alt="Banner 1">
        <img src="imagenes/image3.jfif" alt="Banner 2">
        <img src="imagenes/imagen2.jpg" alt="Banner 3">
    </div>
    <div class="container">
        <!-- Product cards here -->
        <div class="product">
            <img src="imagenes/aire.jpg" alt="Producto 1" height="250px">
            <h2>Aire Acondicionado Split TAC-18CSA/Z2 18000BTU ON/OFF TCL</h2>
            <p>Modelo: TAC-18CSA/Z2<br>
                Modo de Dormir (Sleep Mode)<br>
                Diseño seguro<br>
                Auto-Diagnostico<br>
                Reinicio Automático ante el apagón<br>
                Caños de cobre<br>
                Marca: TCL
            </p>
            <p>Precio: $459.34</p>
            <button onclick="addToCart('Aire Acondicionado Split TAC-18CSA/Z2 18000BTU ON/OFF TCL', 459.34)">Agregar al carrito</button>
        </div>
        <div class="product">
            <img src="imagenes/lavadora.jpg" alt="Producto 2" height="250px">
            <h2>LAVADORA WHIRLPOOL IMPELLER 19KG</h2>
            <p>Modelo: WW19LTAHLA<br>
                La nueva lavadora Whirlpool WW19LTAHLA viene con un sistema de re-circulación Xpert CoverWash de Lavado
                Impeller mejorando el sistema intelicarga el cual podrás ahorrar hasta 24,000 litros de agua utilizando
                solo lo que necesitas dependiendo del tamaño de tu carga.<br>
                Cuenta con una garantía directamente de la marca de 10 años en el motor - 3 años en el panel
            </p>
            <p>Precio: $490.49</p>
            <button onclick="addToCart('LAVADORA WHIRLPOOL IMPELLER 19KG', 490.49)">Agregar al carrito</button>
        </div>
        <div class="product">
            <img src="imagenes/refrigeradora.jpg" alt="Producto 3" height="250px">
            <h2>REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17"</h2>
            <p>Modelo: WRE57BKTWW<br>
                La refrigeradora bottom mount de whirlpool modelo WRE57BKTWW cuenta con tecnología Xpert Inverter que te
                da mayor ahorro de energía y conservación de alimentos. Además tiene lámina anti huellas y capacidad de
                484 Litros
                Marca: Whirlpool
            </p>
            <p>Precio: $798.70</p>
            <button onclick="addToCart('REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17', 798.70)">Agregar al carrito</button>
        </div>
        <div class="product">
            <img src="imagenes/televisor55.jpg" alt="Producto 4" height="250px">
            <h2>TV SMART SAMSUNG 4K 55"</h2>
            <p>Modelo: UN55AU7000PCZE<br>
                El Televisor smart UHD 4K SAMSUNG modelo UN55AU7000PCZE te ofrece una experiencia 4K inteligente.
                Sistema operativo tizen. Procesador Crystal 4K. GRATIS SOPORTE DE TV 40 A 70. Promoción válida hasta el
                31 de Enero del 2023. Marca: Samsung
            </p>
            <p>Precio: $559.06</p>
            <button onclick="addToCart('TV SMART SAMSUNG 4K 55', 559.06)">Agregar al carrito</button>
        </div>
        <div class="product">
            <img src="imagenes/parlante.jpg" alt="Producto 5" height="250px">
            <h2>PARLANTE PORTATIL SONY</h2>
            <p>Modelo: SRS-XE300/BCLA<br>
                El parlante XE300 es perfecto para animar la fiesta con un sonido de calidad. El difusor con forma de
                línea propaga un sonido amplio por todas partes, sin sacrificar la calidad. Además, con una batería de
                larga duración, un tamaño portátil y una durabilidad impresionante, este parlante es el compañero
                perfecto para tu próxima fiesta, sea donde sea. Marca: Sony
            </p>
            <p>Precio: $177.45</p>
            <button onclick="addToCart('PARLANTE PORTATIL SONY', 177.45)">Agregar al carrito</button>
        </div>
    </div>
    <footer>
        <p>Contacto: <a href="mailto:correo@ejemplo.com">correo@ejemplo.com</a> | Tel: 123-456-7890</p>
        <p>Síguenos:
            <a href="#">Facebook</a> |
            <a href="#">Twitter</a> |
            <a href="#">Instagram</a>
            <p>realizado por Jorge Lopez, Carlos Calapucha, Ricardo Andi</p>
        </p>
    </footer>
    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let total = 0;

        function addToCart(product, price) {
            const cartCount = document.getElementById('cart-count');

            // Check if the product is already in the cart
            const existingProduct = cart.find(item => item.product === product);
            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                cart.push({
                    product,
                    price,
                    quantity: 1
                });
            }

            // Save cart to LocalStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Update the cart count display
            cartCount.textContent = cart.reduce((acc, item) => acc + item.quantity, 0);
        }

        // Initialize cart count on page load
        document.addEventListener('DOMContentLoaded', () => {
            const cartCount = document.getElementById('cart-count');
            cartCount.textContent = cart.reduce((acc, item) => acc + item.quantity, 0);
        });
    </script>
</body>

</html>