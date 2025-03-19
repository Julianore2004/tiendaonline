<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include './library/configServer.php';
include './library/consulSQL.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Detalle del Producto</title>
    <?php include './inc/link.php'; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .product-detail {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .product-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .product-image img {
            width: 455px;
            height: 455px;
            object-fit: contain;
        }

        .thumbnails {
            display: flex;
            flex-direction: column;
            gap: 10px;
            position: absolute;
            left: -60px;
            top: 50%;
            transform: translateY(-50%);
        }

        .thumbnails img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .thumbnails img:hover {
            border: 2px solid #007bff;
        }

        .carousel-controls {
            display: flex;
            justify-content: space-between;
            width: 100%;
            position: absolute;
         
        }

        .carousel-controls button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 50%;
        }

        .carousel-controls button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .product-info {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-info h2 {
            margin-top: 20px;
            margin-bottom: 15px;
        }

        .product-info h4 {
            margin: 10px 0;
            margin-bottom: 15px;
        }

        .product-info .price-container {
            align-items: center;
            margin-bottom: 10px;
        }

        .product-info .price-container .price {
            font-size: 20px;
            color: #007bff;
            font-weight: bold;
        }

        .product-info .price-container .original-price {
            font-size: 18px;
            color: #e74c3c;
            text-decoration: line-through;
            margin-left: 10px;
        }

        .product-info .price-container .discount {
            font-size: 18px;
            color: rgb(255, 255, 255);
            padding: 5px;
        }

        .precioDescuento {
            display: flex;
            background-color: #f9f9f9;
            text-align: center;
            max-width: 300px;
        }

        .precioDescuento h4 {
            color: #333;
        }

        .precioDescuento .price {
            color: #e74c3c;
            font-size: 1.5em;
            font-weight: bold;
        }

        .Descuento {
            margin-left: 10px;
            margin-top: 8px;
        }

        .Descuento .discount {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 1.2em;
        }

        .product-info .stock-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-info .stock-container .stock {
            font-size: 18px;
            color: rgb(107, 104, 104);
        }

        .product-info .stock-container .out-of-stock {
            font-size: 18px;
            color: #e74c3c;
        }

        .product-info .add-to-cart-container {
            display: flex;
            align-items: center;
            margin-top: 20px;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .add-to-cart-container {
            width: 100%;
        }

        .product-info .add-to-cart-container {
            margin-right: 10px;
        }

        .product-info .add-to-cart-container .add-to-cart button {
            flex: 1;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .product-info .add-to-cart-container .add-to-cart button:hover {
            background-color: #218838;
        }

        .product-info .login-button {
            background-color: #007bff;
        }

        .product-info .login-button:hover {
            background-color: #0056b3;
        }

        .product-info .back-to-store {
            background-color: #dc3545;
        }

        .product-info .back-to-store:hover {
            background-color: #c82333;
        }

        .quantity-buttons {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            max-width: 200px;
            margin: 0 auto;
        }

        .quantity-buttons button {
            background-color: rgb(48, 48, 48);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
            flex: 1;
        }

        .quantity-buttons button:hover {
            background-color: rgb(184, 64, 35);
        }

        .quantity-buttons input[type="number"] {
            width: 50px;
            text-align: center;
            border: none;
            font-size: 16px;
            flex: 0 0 50px;
        }

        .quantity-buttons input[type="number"]:focus {
            outline: none;
        }

        @media (max-width: 768px) {
            .product-container {
                flex-direction: column;
                align-items: center;
            }

            .product-image,
            .product-info {
                width: 100%;
                margin-bottom: 20px;
            }

            .product-image img {
                width: 100%;
                height: auto;
            }

            .thumbnails {
                position: static;
                flex-direction: row;
                justify-content: center;
                margin-top: 10px;
            }

            .thumbnails img {
                width: 70px;
                height: 70px;
            }

            .quantity-buttons {
                max-width: 150px;
            }

            .quantity-buttons button {
                padding: 8px;
                font-size: 14px;
            }

            .quantity-buttons input[type="number"] {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .quantity-buttons {
                max-width: 100px;
            }

            .quantity-buttons button {
                padding: 6px;
                font-size: 12px;
            }

            .quantity-buttons input[type="number"] {
                font-size: 12px;
            }
        }

        #carro {
            width: 100%;
        }

        .productseparado h4 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }

        .productseparado h4 strong {
            flex: 1;
            text-align: left;
        }

        .productseparado h4 span {
            flex: 1;
            text-align: right;
        }

        .stock-container .stock {
            color: green;
        }

        .stock-container .out-of-stock {
            color: red;
        }

        .btn-success {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-success:hover {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .add-to-cart-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .add-to-cart-container .quantity-buttons {
            flex: 1;
        }

        .add-to-cart-container #carro {
            flex: 1;
        }
    </style>
</head>

<body id="container-page-product">
    <?php include './inc/navbar.php'; ?>
    <section id="container-pedido">
        <br>
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <h1>Detalle del Producto <small class="tittles-pages-logo">XTREME AI</small></h1>
                </div>
                <?php
                $CodigoProducto = consultasSQL::clean_string($_GET['CodigoProd']);
                $productoinfo = ejecutarSQL::consultar("SELECT producto.CodigoProd, producto.CodigoDeProducto, producto.NombreProd, producto.CodigoCat, categoria.Nombre, producto.Precio, producto.Descuento, producto.Stock, producto.Imagen, producto.Imagen1, producto.Imagen2, producto.Imagen3, producto.Imagen4, producto.Condicion FROM categoria INNER JOIN producto ON producto.CodigoCat=categoria.CodigoCat WHERE CodigoProd='" . $CodigoProducto . "'");
                while ($fila = mysqli_fetch_array($productoinfo, MYSQLI_ASSOC)) {
                    $precioDescuento = number_format(($fila['Precio'] - ($fila['Precio'] * ($fila['Descuento'] / 100))), 2, '.', '');
                    $precioOriginal = number_format($fila['Precio'], 2, '.', '');
                    echo '
                            <div class="product-container">
                                <div class="product-image">
                                    <img id="main-image" class="img-responsive" src="' . ($fila['Imagen'] != "" && is_file("./assets/img-products/" . $fila['Imagen']) ? "./assets/img-products/" . $fila['Imagen'] : "./assets/img-products/default.png") . '">
                                    <div class="thumbnails">';
                    if ($fila['Imagen'] != "") {
                        echo '<img src="' . ($fila['Imagen'] != "" && is_file("./assets/img-products/" . $fila['Imagen']) ? "./assets/img-products/" . $fila['Imagen'] : "./assets/img-products/default.png") . '" onclick="changeImage(this.src)">';
                    }
                    if ($fila['Imagen1'] != "") {
                        echo '<img src="' . $fila['Imagen1'] . '" onclick="changeImage(this.src)">';
                    }
                    if ($fila['Imagen2'] != "") {
                        echo '<img src="' . $fila['Imagen2'] . '" onclick="changeImage(this.src)">';
                    }
                    if ($fila['Imagen3'] != "") {
                        echo '<img src="' . $fila['Imagen3'] . '" onclick="changeImage(this.src)">';
                    }
                    if ($fila['Imagen4'] != "") {
                        echo '<img src="' . $fila['Imagen4'] . '" onclick="changeImage(this.src)">';
                    }
                    echo '</div>
                                    <div class="carousel-controls">
                                        <button onclick="prevImage()">&#10094;</button>
                                        <button onclick="nextImage()">&#10095;</button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h2><strong>' . $fila['NombreProd'] . '</strong></h2>

                                    <div class="productseparado">
                                        <h4><strong>Código de Producto:</strong> ' . $fila['CodigoDeProducto'] . '</h4>
                                        <h4><strong>Categoría:</strong> ' . $fila['Nombre'] . '</h4>
                                        <h4><strong>Condición:</strong> ' . $fila['Condicion'] . '</h4>
                                        <h4><strong>Stock:</strong> <span class="' . ($fila['Stock'] >= 1 ? 'stock' : 'out-of-stock') . '">' . ($fila['Stock'] >= 1 ? $fila['Stock'] : 'No hay existencias') . '</span></h4>
                                    </div>
                                    <div class="price-container">';
                    if ($fila['Descuento'] > 0) {
                        echo '
                                        <div class="precioDescuento">
                                            <h4><strong>Oferta:</strong> <span class="price">S/ ' . $precioDescuento . '</span></h4>
                                            <div class="Descuento">
                                                <span class="discount">- ' . $fila['Descuento'] . '%</span>
                                            </div>
                                        </div>
                                        <h4><strong>Precio:</strong> <span class="original-price">S/ ' . $precioOriginal . '</span></h4>';
                    } else {
                        echo ' <h4><strong>Precio:</strong> <span class="price">S/ ' . $precioOriginal . '</span></h4>';
                    }
                    echo '</div>';
                    if ($fila['Stock'] >= 1) {
                        if (isset($_SESSION['nombreAdmin']) && !empty($_SESSION['nombreAdmin']) || isset($_SESSION['nombreUser']) && !empty($_SESSION['nombreUser'])) {
                            echo '<form action="process/carrito.php" method="POST" class="FormCatElec add-to-cart" data-form="">
                                                <input type="hidden" value="' . $fila['CodigoProd'] . '" name="codigo">
                                                <div class="add-to-cart-container">
                                                    <div class="quantity-buttons">
                                                        <button type="button" onclick="decrementQuantity()">-</button>
                                                        <input type="number" id="quantity" name="cantidad" value="1" min="1" max="' . $fila['Stock'] . '" readonly>
                                                        <button type="button" onclick="incrementQuantity()">+</button>
                                                    </div>
                                                    <div id="carro">
                                                        <button class="btn-lg btn-raised btn-success btn-block"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; Añadir al carrito</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="ResForm"></div>';
                        } else {
                            echo '<p class="text-center"><small>Para agregar productos al carrito de compras debes iniciar sesión</small></p><br>';
                            echo '<button class="btn btn-lg btn-raised btn-info btn-block login-button" data-toggle="modal" data-target=".modal-login"><i class="fa fa-user"></i>&nbsp;&nbsp; Iniciar sesión</button>';
                        }
                    }
                    echo '<a href="product.php" class="btn btn-lg btn-danger btn-raised btn-block back-to-store"><i class="fa fa-mail-reply"></i>&nbsp;&nbsp;Regresar a la tienda</a>
                                </div>
                            </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <?php include './inc/footer.php'; ?>

    <script>
        let currentIndex = 0;
        const thumbnails = document.querySelectorAll('.thumbnails img');
        const mainImage = document.getElementById('main-image');

        function changeImage(src) {
            mainImage.src = src;
            currentIndex = Array.from(thumbnails).findIndex(img => img.src === src);
        }

        function startCarousel() {
            setInterval(() => {
                currentIndex = (currentIndex + 1) % thumbnails.length;
                changeImage(thumbnails[currentIndex].src);
            }, 8000); // Cambia la imagen cada 3 segundos
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
            changeImage(thumbnails[currentIndex].src);
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % thumbnails.length;
            changeImage(thumbnails[currentIndex].src);
        }

        function incrementQuantity() {
            var quantityInput = document.getElementById('quantity');
            var currentValue = parseInt(quantityInput.value);
            var maxValue = parseInt(quantityInput.max);
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        }

        function decrementQuantity() {
            var quantityInput = document.getElementById('quantity');
            var currentValue = parseInt(quantityInput.value);
            var minValue = parseInt(quantityInput.min);
            if (currentValue > minValue) {
                quantityInput.value = currentValue - 1;
            }
        }

        // Iniciar el carrusel automático al cargar la página
        window.onload = startCarousel;
    </script>

</body>

</html>

