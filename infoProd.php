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
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
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
        }

        .product-image,
        .product-info {
            flex: 1;
            min-width: 300px;
        }

        .product-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-info {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-info h2 {
            margin-top: 0;
            color: #343a40;
        }

        .product-info h4 {
            margin: 10px 0;
            color: #6c757d;
        }

        .product-info .price-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-info .price-container .price {
            font-size: 24px;
            color: #e74c3c;
            font-weight: bold;
        }

        .product-info .price-container .original-price {
            font-size: 18px;
            color: #999;
            text-decoration: line-through;
            margin-left: 10px;
        }

        .product-info .price-container .discount {
            font-size: 18px;
            color: #28a745;
            margin-left: 10px;
        }

        .product-info .stock-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-info .stock-container .stock {
            font-size: 18px;
            color: #28a745;
        }

        .product-info .stock-container .out-of-stock {
            font-size: 18px;
            color: #e74c3c;
        }

        .product-info .add-to-cart-container {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }
        .add-to-cart-container{
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
            width: 19%;
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
        }

        .quantity-buttons button {
            background-color:rgb(48, 48, 48);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
        }

        .quantity-buttons button:hover {
            background-color:rgb(184, 64, 35);
        }

        .quantity-buttons input[type="number"] {
            width: 50px;
            text-align: center;
            border: none;
            font-size: 16px;
        }

        .quantity-buttons input[type="number"]:focus {
            outline: none;
        }
        @media (max-width: 768px) {
            .product-image,
            .product-info {
                margin-bottom: 20px;
            }
        }
       #carro{
        width: 81%;
       }
    </style>
</head>

<body id="container-page-product">
    <?php include './inc/navbar.php'; ?>
    <section id="infoproduct" class="product-detail">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <h1>Detalle del Producto <small class="tittles-pages-logo">XTREME AI</small></h1>
                </div>
                <?php
                $CodigoProducto = consultasSQL::clean_string($_GET['CodigoProd']);
                $productoinfo = ejecutarSQL::consultar("SELECT producto.CodigoProd, producto.CodigoDeProducto, producto.NombreProd, producto.CodigoCat, categoria.Nombre, producto.Precio, producto.Descuento, producto.Stock, producto.Imagen, producto.Condicion FROM categoria INNER JOIN producto ON producto.CodigoCat=categoria.CodigoCat WHERE CodigoProd='" . $CodigoProducto . "'");
                while ($fila = mysqli_fetch_array($productoinfo, MYSQLI_ASSOC)) {
                    $precioDescuento = number_format(($fila['Precio'] - ($fila['Precio'] * ($fila['Descuento'] / 100))), 2, '.', '');
                    $precioOriginal = number_format($fila['Precio'], 2, '.', '');
                    echo '
                            <div class="product-container">
                                <div class="product-image">
                                    <img class="img-responsive" src="' . ($fila['Imagen'] != "" && is_file("./assets/img-products/" . $fila['Imagen']) ? "./assets/img-products/" . $fila['Imagen'] : "./assets/img-products/default.png") . '">
                                </div>
                                <div class="product-info">
                                    <h2><strong>' . $fila['NombreProd'] . '</strong></h2>
                                    <h4><strong>Código de Producto:</strong> ' . $fila['CodigoDeProducto'] . '</h4>
                                    <div class="price-container">';
                    if ($fila['Descuento'] > 0) {
                        echo '<span class="price">S/ ' . $precioDescuento . '</span>
                              <span class="original-price">S/ ' . $precioOriginal . '</span>
                              <span class="discount">(' . $fila['Descuento'] . '% off)</span>';
                    } else {
                        echo '<span class="price">S/ ' . $precioOriginal . '</span>';
                    }
                    echo '</div>
                                    <div class="stock-container">
                                        <h4><strong>Stock:</strong>   <span class="' . ($fila['Stock'] >= 1 ? 'stock' : 'out-of-stock') . '">' . ($fila['Stock'] >= 1 ? $fila['Stock'] : 'No hay existencias') . '</span></h4>
                                    </div>
                                    <h4><strong>Categoría:</strong> ' . $fila['Nombre'] . '</h4>
                                    <h4><strong>Condición:</strong> ' . $fila['Condicion'] . '</h4>';
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
                                                    <button  class="btn btn-lg btn-raised btn-success btn-block"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; Añadir al carrito</button>
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
    </script>

</body>

</html>
