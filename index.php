<!DOCTYPE html>
<html lang="es">
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
    }

    .product-card .product-description {
        flex-grow: 1;
        margin: 10px 0;
    }

    .product-card .product-price {
        margin-bottom: 10px;
    }
</style>
<head>
    <title>Inicio</title>
    <?php include './inc/link.php'; ?>
</head>

<body id="container-page-index">
    <?php include './inc/navbar.php'; ?>

    <section id="slider-store" class="carousel slide" data-ride="carousel" style="padding: 0;">

        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#slider-store" data-slide-to="0" class="active"></li>
            <li data-target="#slider-store" data-slide-to="1"></li>
            <li data-target="#slider-store" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="./assets/img/huanta1.png" alt="slider1">
                <div class="carousel-caption">
                    Huanta - Arco de la Gratuidad
                </div>
            </div>
            <div class="item">
                <img src="./assets/img/huanta2.png" alt="slider2">
                <div class="carousel-caption">
                    Huanta - Fuente del Parque Central 
                </div>
            </div>
            <div class="item">
                <img src="./assets/img/huanta3.png" alt="slider3">
                <div class="carousel-caption">
                    Huanta - Parque Central
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#slider-store" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previo</span>
        </a>
        <a class="right carousel-control" href="#slider-store" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </section>


    <section id="new-prod-index">
    <div class="container-fluid">
                <div class="row">
                  <div class="col-xs-12 col-md-4 col-md-offset-4">
                    <form action="./search.php" method="GET">
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                          <input type="text" id="addon1" class="form-control" name="term" required="" placeholder="Escriba nombre o marca del producto" title="Escriba nombre o marca del producto">
                          <span class="input-group-btn">
                              <button class="btn btn-warning btn-raised" type="submit">Buscar</button>
                          </span>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="container">
    <div class="page-header">
        <h1>Nuestros Productos</h1>
    </div>
    <div class="row">
        <?php
        include 'library/configServer.php';
        include 'library/consulSQL.php';
        $consulta = ejecutarSQL::consultar("SELECT * FROM producto WHERE Stock > 0 AND Estado='Activo' ORDER BY id DESC /* LIMIT 7 */");
        $totalproductos = mysqli_num_rows($consulta);
        if ($totalproductos > 0) {
            while ($fila = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
        ?>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="thumbnail product-card">
                        <div class="img-container">
                            <img class="img-product" src="assets/img-products/<?php if ($fila['Imagen'] != "" && is_file("./assets/img-products/" . $fila['Imagen'])) {
                                                                                        echo $fila['Imagen'];
                                                                                    } else {
                                                                                        echo "default.png";
                                                                                    } ?>">
                        </div>
                        <div class="caption">
                            <h3 class="product-title"><?php echo $fila['Marca']; ?></h3>
                            <p class="product-description"><?php echo $fila['NombreProd']; ?></p>
                            <?php if ($fila['Descuento'] > 0): ?>
                                <p class="product-price">
                                    <?php
                                    $pref = number_format($fila['Precio'] - ($fila['Precio'] * ($fila['Descuento'] / 100)), 2, '.', '');
                                    echo $fila['Descuento'] . "% descuento: S/." . $pref;
                                    ?>
                                </p>
                            <?php else: ?>
                                <p class="product-price">S/.<?php echo $fila['Precio']; ?></p>
                            <?php endif; ?>
                            <p class="text-center">
                                <a href="infoProd.php?CodigoProd=<?php echo $fila['CodigoProd']; ?>" class="btn btn-success btn-sm btn-raised btn-block"><i class="fa fa-plus"></i>&nbsp; Detalles</a>
                            </p>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<h2>No hay productos registrados en la tienda</h2>';
        }
        ?>
    </div>
</div>




    </section>
    <section id="reg-info-index">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 text-center">
                    <article style="margin-top:5%;">
                        <p><i class="fa fa-user-secret fa-4x"></i></p>
                        <h3>Registrate</h3>
                        <p>Registrate como cliente de <span class="tittles-pages-logo">Xtreme AI</span> en un sencillo formulario para poder completar tus pedidos</p>
                        <p><a href="registration.php" class="btn btn-warning btn-raised btn-block">Registrarse</a></p>
                    </article>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <img src="assets/img/tv.png" alt="Smart-TV" class="img-responsive" style="width: 70%; display: block; margin: 0 auto;">
                </div>
            </div>
        </div>
    </section>

    <?php include './inc/footer.php'; ?>
</body>

</html>