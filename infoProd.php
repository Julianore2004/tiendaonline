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
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product-info {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product-info h3 {
            margin-top: 0;
            color: #333;
        }
        .product-info h4 {
            margin: 10px 0;
            color: #555;
        }
        .product-info .price {
            color: #e74c3c;
            font-size: 24px;
        }
        .product-info .stock {
            color: #2ecc71;
        }
        .product-info .out-of-stock {
            color: #e74c3c;
        }
        .product-info .add-to-cart {
            margin-top: 20px;
        }
        .product-info .add-to-cart input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .product-info .add-to-cart button {
            width: 100%;
            padding: 10px;
            background-color: #2ecc71;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .product-info .add-to-cart button:hover {
            background-color: #27ae60;
        }
        .product-info .login-button {
            background-color: #3498db;
        }
        .product-info .login-button:hover {
            background-color: #2980b9;
        }
        .product-info .back-to-store {
            background-color: #e74c3c;
        }
        .product-info .back-to-store:hover {
            background-color: #c0392b;
        }
        .quantity-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .quantity-buttons button {
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantity-buttons input {
            width: 50px;
            text-align: center;
            border: 1px solid #ccc;
            padding: 5px;
            margin: 0 5px;
            border-radius: 4px;
        }
        @media (max-width: 768px) {
            .product-image, .product-info {
                margin-bottom: 20px;
            }
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
                    $productoinfo = ejecutarSQL::consultar("SELECT producto.CodigoProd, producto.CodigoDeProducto, producto.NombreProd, producto.CodigoCat, categoria.Nombre, producto.Precio, producto.Descuento, producto.Stock, producto.Imagen, producto.Condicion FROM categoria INNER JOIN producto ON producto.CodigoCat=categoria.CodigoCat WHERE CodigoProd='".$CodigoProducto."'");
                    while ($fila = mysqli_fetch_array($productoinfo, MYSQLI_ASSOC)) {
                        echo '
                            <div class="col-xs-12 col-md-6 product-image">
                                <img class="img-responsive" src="'.($fila['Imagen'] != "" && is_file("./assets/img-products/".$fila['Imagen']) ? "./assets/img-products/".$fila['Imagen'] : "./assets/img-products/default.png").'">
                            </div>
                            <div class="col-xs-12 col-md-6 product-info">
                                <h3 class="text-center">Información del Producto</h3>
                                <h4><strong>Nombre:</strong> '.$fila['NombreProd'].'</h4>
                                <h4><strong>Código de Producto:</strong> '.$fila['CodigoDeProducto'].'</h4>
                                <h4 class="price"><strong>Precio:</strong> S/.'.number_format(($fila['Precio']-($fila['Precio']*($fila['Descuento']/100))), 2, '.', '').'</h4>
                                <h4><strong>Cantidad:</strong> <span class="'.($fila['Stock'] >= 1 ? 'stock' : 'out-of-stock').'">'.($fila['Stock'] >= 1 ? $fila['Stock'] : 'No hay existencias').'</span></h4>
                                <h4><strong>Categoría:</strong> '.$fila['Nombre'].'</h4>
                                <h4><strong>Condición:</strong> '.$fila['Condicion'].'</h4>';
                                if ($fila['Stock'] >= 1) {
                                    if (isset($_SESSION['nombreAdmin']) && !empty($_SESSION['nombreAdmin']) || isset($_SESSION['nombreUser']) && !empty($_SESSION['nombreUser'])) {
                                        echo '<form action="process/carrito.php" method="POST" class="FormCatElec add-to-cart" data-form="">
                                            <input type="hidden" value="'.$fila['CodigoProd'].'" name="codigo">
                                            <label class="text-center"><small>Agrega la cantidad de productos que añadirás al carrito de compras (Máximo '.$fila['Stock'].' productos)</small></label>
                                            <div class="quantity-buttons">
                                                <button type="button" onclick="decrementQuantity()">-</button>
                                                <input type="number" id="quantity" name="cantidad" value="1" min="1" max="'.$fila['Stock'].'" readonly>
                                                <button type="button" onclick="incrementQuantity()">+</button>
                                            </div>
                                            <button class="btn btn-lg btn-raised btn-success btn-block"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; Añadir al carrito</button>
                                        </form>
                                        <div class="ResForm"></div>';
                                    } else {
                                        echo '<p class="text-center"><small>Para agregar productos al carrito de compras debes iniciar sesión</small></p><br>';
                                        echo '<button class="btn btn-lg btn-raised btn-info btn-block login-button" data-toggle="modal" data-target=".modal-login"><i class="fa fa-user"></i>&nbsp;&nbsp; Iniciar sesión</button>';
                                    }
                                }
                                echo '<a href="product.php" class="btn btn-lg btn-danger btn-raised btn-block back-to-store"><i class="fa fa-mail-reply"></i>&nbsp;&nbsp;Regresar a la tienda</a>
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

