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

        #searchResults {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1000;
            background: #fff;
            border: 1px solid #ccc;
            border-top: none;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }

        #searchResults .list-group-item {
            display: flex;
            align-items: center;
            padding: 10px;
        }

        #searchResults .list-group-item img {
            max-width: 50px;
            max-height: 50px;
            margin-right: 10px;
        }
    </style>
</head>
<body id="container-page-product">
    <?php include './inc/navbar.php'; ?>
    <section id="store">
       <br>
        <div class="container">
            <div class="page-header">
              <h1>BÚSQUEDA DE PRODUCTOS <small class="tittles-pages-logo">STORE</small></h1>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-xs-12 col-md-4 col-md-offset-8">
                  <form action="./search.php" method="GET">
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                        <input type="text" id="searchInput" class="form-control" name="term" required="" placeholder="Escriba nombre o marca del producto" title="Escriba nombre o marca del producto">
                        <span class="input-group-btn">
                        <button class="btn btn-warning btn-raised" type="submit">Buscar</button>
                        </span>
                      </div>
                    </div>
                  </form>
                  <div id="searchResults" class="list-group"></div>
                </div>
              </div>
            </div>
            <?php
              $search = consultasSQL::clean_string($_GET['term'] ?? '');
              if (!empty($search)) {
            ?>
              <div class="container-fluid">
                <div class="row">
                  <?php
                    $mysqli = mysqli_connect(SERVER, USER, PASS, BD);
                    mysqli_set_charset($mysqli, "utf8");

                    $pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;
                    $regpagina = 20;
                    $inicio = ($pagina > 1) ? (($pagina * $regpagina) - $regpagina) : 0;

                    $consultar_productos = mysqli_query($mysqli, "SELECT SQL_CALC_FOUND_ROWS * FROM producto WHERE NombreProd LIKE '%" . $search . "%' OR Modelo LIKE '%" . $search . "%' OR Marca LIKE '%" . $search . "%' LIMIT $inicio, $regpagina");

                    $totalregistros = mysqli_query($mysqli, "SELECT FOUND_ROWS()");
                    $totalregistros = mysqli_fetch_array($totalregistros, MYSQLI_ASSOC);

                    $numeropaginas = ceil($totalregistros["FOUND_ROWS()"] / $regpagina);

                    if (mysqli_num_rows($consultar_productos) >= 1) {
                      echo '<div class="col-xs-12"><h3 class="text-center">Se muestran los productos con el nombre, marca o modelo <strong>"' . $search . '"</strong></h3></div><br>';
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
                              <a href="search.php?term=<?php echo $search; ?>&pag=<?php echo $pagina - 1; ?>">
                                  <span aria-hidden="true">&laquo;</span>
                              </a>
                          </li>
                      <?php endif; ?>

                      <?php
                          for ($i = 1; $i <= $numeropaginas; $i++) {
                              if ($pagina == $i) {
                                  echo '<li class="active"><a href="search.php?term=' . $search . '&pag=' . $i . '">' . $i . '</a></li>';
                              } else {
                                  echo '<li><a href="search.php?term=' . $search . '&pag=' . $i . '">' . $i . '</a></li>';
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
                              <a href="search.php?term=<?php echo $search; ?>&pag=<?php echo $pagina + 1; ?>">
                                  <span aria-hidden="true">&raquo;</span>
                              </a>
                          </li>
                      <?php endif; ?>
                    </ul>
                  </div>
                  <?php
                    endif;
                    } else {
                      echo '<h2 class="text-center">Lo sentimos, no hemos encontrado productos con el nombre, marca o modelo <strong>"' . $search . '"</strong></h2>';
                    }
                  ?>
                </div>
              </div>
            <?php
              } else {
                  echo '<h2 class="text-center">Por favor escriba el nombre o marca del producto que desea buscar</h2>';
              }
            ?>
        </div>
    </section>
    <?php include './inc/footer.php'; ?>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value;
            if (query.length > 2) { // Solo realiza la búsqueda si la consulta tiene más de 2 caracteres
                fetch('search_suggestions.php?term=' + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = ''; // Limpia los resultados anteriores
                        if (data.length > 0) {
                            searchResults.style.display = 'block';
                            data.forEach(item => {
                                const listItem = document.createElement('a');
                                listItem.href = 'infoProd.php?CodigoProd=' + item.CodigoProd;
                                listItem.className = 'list-group-item';
                                listItem.innerHTML = `
                                    <img src="./assets/img-products/${item.Imagen}" alt="${item.NombreProd}">
                                    <div>
                                        <h5>${item.NombreProd}</h5>
                                        <p>S/.${item.Precio}</p>
                                    </div>
                                `;
                                searchResults.appendChild(listItem);
                            });
                        } else {
                            searchResults.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                searchResults.style.display = 'none';
            }
        });

        document.addEventListener('click', function(event) {
            if (!searchResults.contains(event.target) && !searchInput.contains(event.target)) {
                searchResults.style.display = 'none';
            }
        });
    });
</script>
</html>
