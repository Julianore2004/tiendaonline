<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <?php include './inc/link.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .table {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table thead th {
            background-color: #007bff;
            color: #fff;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-raised {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .product-image img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body id="container-page-index">
    <?php include './inc/navbar.php'; ?>
    <section id="container-pedido">
        <div class="container mt-5">
            <div class="page-header">
                <h1>CARRITO DE COMPRAS <small class="tittles-pages-logo">Xtreme AI</small></h1>
            </div>
            <div class="row mt-4">
                <div class="col-xs-12">
                    <?php
                        require_once "library/configServer.php";
                        require_once "library/consulSQL.php";
                        if (!empty($_SESSION['carro'])) {
                            $suma = 0;
                            $sumaA = 0;
                            echo '<table class="table table-bordered table-hover"><thead><tr class="bg-success"><th>Imagen</th><th>Nombre</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Acciones</th></tr></thead>';
                            foreach ($_SESSION['carro'] as $codeProd) {
                                $consulta = ejecutarSQL::consultar("SELECT * FROM producto WHERE CodigoProd='" . $codeProd['producto'] . "'");
                                while ($fila = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
                                    $pref = number_format(($fila['Precio'] - ($fila['Precio'] * ($fila['Descuento'] / 100))), 2, '.', '');
                                    echo "<tbody>
                                        <tr>
                                            <td class='product-image'><img src='./assets/img-products/" . ($fila['Imagen'] != "" && is_file("./assets/img-products/" . $fila['Imagen']) ? $fila['Imagen'] : "default.png") . "' alt='" . $fila['NombreProd'] . "'></td>
                                            <td>{$fila['NombreProd']}</td>
                                            <td>{$pref}</td>
                                            <td>{$codeProd['cantidad']}</td>
                                            <td>" . $pref * $codeProd['cantidad'] . "</td>
                                            <td>
                                                <form action='process/quitarproducto.php' method='POST' class='FormCatElec' data-form=''>
                                                    <input type='hidden' value='{$codeProd['producto']}' name='codigo'>
                                                    <button class='btn btn-danger btn-raised btn-xs'><i class='fas fa-trash-alt'></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>";
                                    $suma += $pref * $codeProd['cantidad'];
                                    $sumaA += $codeProd['cantidad'];
                                }
                                mysqli_free_result($consulta);
                            }
                            echo '<tr class="bg-danger"><td colspan="3">Total</td><td><strong>' . $sumaA . '</strong></td><td><strong>S/. ' . number_format($suma, 2) . '</strong></td></tr></table><div class="ResForm"></div>';
                            echo '
                            <p class="text-center">
                                <a href="product.php" class="btn btn-primary btn-raised btn-lg"><i class="fas fa-shopping-cart"></i> Seguir comprando</a>
                                <a href="process/vaciarcarrito.php" class="btn btn-success btn-raised btn-lg"><i class="fas fa-trash"></i> Vaciar el carrito</a>
                         <a href="process/confirmarpedido.php" class="btn btn-danger btn-raised btn-lg"><i class="fas fa-check"></i> Confirmar el pedido</a>
   </p>
                            ';
                        } else {
                            echo '<p class="text-center text-danger lead">El carrito de compras está vacío</p><br>
                            <a href="product.php" class="btn btn-primary btn-lg btn-raised"><i class="fas fa-shopping-cart"></i> Ir a Productos</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php include './inc/footer.php'; ?>
</body>
</html>
