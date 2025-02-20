<?php
include './library/configServer.php';
include './library/consulSQL.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Productos</title>
    <?php include './inc/link.php'; ?>
    <style>
        .product-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .img-container {
            height: 200px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .img-container .img-product {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }

        .product-card .caption {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card .product-title {
            font-size: 1.2em;
            margin-top: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-card .product-description {
            flex-grow: 1;
            margin: 10px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-card .product-price {
            margin-bottom: 10px;
        }
    </style>
</head>
<body id="container-page-product">
    <?php include './inc/navbar.php'; ?>
    <section id="store">
       <br>
        <div class="container">
            <div class="page-header">
              <h1>PRODUCTOS <small class="tittles-pages-logo">STORE</small></h1>
            </div>
            <div class="container-fluid">
              <div class="row">
                <?php
                  $mysqli = mysqli_connect(SERVER, USER, PASS, BD);
                  mysqli_set_charset($mysqli, "utf8");

                  $pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;
                  $regpagina = 20;
                  $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;

                  $consultar_productos = mysqli_query($mysqli, "SELECT SQL_CALC_FOUND_ROWS * FROM producto WHERE Stock > 0 AND Estado='Activo' LIMIT $inicio, $regpagina");

                  $totalregistros = mysqli_query($mysqli, "SELECT FOUND_ROWS()");
                  $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);

                  $numeropaginas = ceil($totalregistros["FOUND_ROWS()"] / $regpagina);

                  if (mysqli_num_rows($consultar_productos) >= 1) {
                    while ($prod = mysqli_fetch_array($consultar_productos, MYSQLI_ASSOC)) {
                ?>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                         <div class="thumbnail product-card">
                           <div class="img-container">
                              <img class="img-product" src="./assets/img-products/<?php if ($prod['Imagen'] != "" && is_file("./assets/img-products/" . $prod['Imagen'])) { echo $prod['Imagen']; } else { echo "default.png"; } ?>">
                           </div>
                           <div class="caption">
                             <h3 class="product-title"><?php echo $prod['Marca']; ?></h3>
                             <p class="product-description"><?php echo $prod['NombreProd']; ?></p>
                             <p class="product-price">$<?php echo $prod['Precio']; ?></p>
                             <p class="text-center">
                                 <a href="infoProd.php?CodigoProd=<?php echo $prod['CodigoProd']; ?>" class="btn btn-warning btn-raised btn-sm btn-block"><i class="fa fa-plus"></i>&nbsp; Detalles</a>
                             </p>
                           </div>
                         </div>
                     </div>
                <?php
                    }
                    if ($numeropaginas > 0):
                ?>
                <div class="clearfix"></div>
                <div class="text-center">
                  <ul class="pagination">
                    <?php if ($pagina == 1): ?>
                        <li class="disabled">
                            <a>
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="search.php?pag=<?php echo $pagina - 1; ?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                        for ($i = 1; $i <= $numeropaginas; $i++) {
                            if ($pagina == $i) {
                                echo '<li class="active"><a href="search.php?pag=' . $i . '">' . $i . '</a></li>';
                            } else {
                                echo '<li><a href="search.php?pag=' . $i . '">' . $i . '</a></li>';
                            }
                        }
                    ?>

                    <?php if ($pagina == $numeropaginas): ?>
                        <li class="disabled">
                            <a>
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="search.php?pag=<?php echo $pagina + 1; ?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                  </ul>
                </div>
                <?php
                  endif;
                  } else {
                    echo '<h2 class="text-center">Lo sentimos, no hay productos registrados en la tienda</h2>';
                  }
                ?>
              </div>
            </div>
        </div>
    </section>
    <?php include './inc/footer.php'; ?>
</body>
</html>
