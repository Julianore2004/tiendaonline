<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_PARSE);

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "guardian.tale3";
$dbname = "tddiego";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener las categorías
$sql = "SELECT CodigoCat, Nombre FROM categoria";
$result = $conn->query($sql);
?>

<style>
    .navbar-container {
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 10px 0;
    }

    .top-section {
        padding-bottom: 5px;
        border-bottom: 1px solid #eee;
        margin-bottom: 5px;
    }

    .brand-name {
       
        font-size: 24px;
        font-weight: bold;
        margin: 0;
        line-height: 40px;
    }

    .nav-links {
        display: flex;
        justify-content: flex-start;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-links li {
        margin-right: 20px;
    }

    .nav-links a {
        color: #333;
        text-decoration: none;
        font-size: 14px;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        min-width: 160px;
        padding: 5px 0;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        box-shadow: 0 6px 12px rgba(0,0,0,.175);
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    @media (max-width: 768px) {
        .top-section {
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .nav-links {
            flex-direction: column;
        }

        .nav-links li {
            margin: 5px 0;
        }
    }

    .search-container {
        margin-top: 5px;
        position: relative;
        width: 100%;
    }

    .input-group {
        display: flex;
        width: 100%;
    }

    .search-box {
        flex: 1;
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 4px 0 0 4px;
        width: 100%;
    }

    .input-group-append {
        display: flex;
    }

    .custom-btn {
        border-radius: 0 4px 4px 0;
        padding: 8px 15px;
        background-color: #e74c3c;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .custom-btn:hover {
        background-color: #007bff;
    }

    .search-results {
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

    .search-results .list-group-item {
        display: flex;
        align-items: center;
        padding: 10px;
    }

    .search-results .list-group-item img {
        max-width: 50px;
        max-height: 50px;
        margin-right: 10px;
    }
</style>

<nav class="navbar-container">
    <div class="container">
        <!-- Sección superior -->
        <div class="row top-section">
            <div class="col-md-2">
                <h1 class="brand-name">Xtreme AI</h1>
            </div>
            <div class="col-md-7">
                <div class="search-container">
                    <form action="search.php" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" class="search-box" name="term" placeholder="Buscar...">
                            <div class="input-group-append">
                                <button type="submit" class="custom-btn"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <div id="searchResults" class="search-results"></div>
                </div>
            </div>
            <div class="col-md-3 text-right">
                <?php
                if (!empty($_SESSION['nombreAdmin'])) {
                    echo '
                        <a href="#!" class="btn btn-link exit-system">
                            <i class="fa fa-user"></i> '.$_SESSION['nombreAdmin'].'
                        </a>
                    ';
                } elseif (!empty($_SESSION['nombreUser'])) {
                    echo '
                        <a href="#!" class="btn btn-link exit-system">
                            <i class="fa fa-user"></i> '.$_SESSION['nombreUser'].'
                        </a>
                        <a href="#!" class="btn btn-link userConBtn" data-code="'.$_SESSION['UserNIT'].'">
                            <i class="glyphicon glyphicon-cog"></i>
                        </a>
                    ';
                } else {
                    echo '
                        <a href="#" class="btn btn-link" data-toggle="modal" data-target=".modal-login">
                            <i class="fa fa-user"></i> Iniciar Sesión
                        </a>
                    ';
                }
                ?>
            </div>
        </div>

        <!-- Sección de navegación -->
        <div class="row">
            <div class="col-md-12">
                <ul class="nav-links">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="product.php">Productos</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Categorías</a>
                        <ul class="dropdown-menu">
                            <li><a href="product.php">Todas las categorías</a></li>
                            <li role="separator" class="divider"></li>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<li><a href="product.php?categ=' . $row["CodigoCat"] . '">' . $row["Nombre"] . '</a></li>';
                                }
                            } else {
                                echo '<li><a href="#">No hay categorías disponibles</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                    if (!empty($_SESSION['nombreAdmin'])) {
                        echo '
                            <li><a href="carrito.php">Carrito</a></li>
                            <li><a href="configAdmin.php">Administración</a></li>
                        ';
                    } elseif (!empty($_SESSION['nombreUser'])) {
                        echo '
                            <li><a href="pedido.php">Pedido</a></li>
                            <li><a href="carrito.php">Carrito</a></li>
                        ';
                    } else {
                        echo '<li><a href="registration.php">Registro</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Modal de Login -->
<div class="modal fade modal-login" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" id="modal-form-login" style="padding: 15px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <p class="text-center text-primary">
                    <i class="fa fa-user-circle-o fa-3x" aria-hidden="true"></i>
                </p>
                <h4 class="modal-title text-center text-primary" id="myModalLabel">Iniciar sesión</h4>
            </div>
            <form action="process/login.php" method="post" role="form" class="FormCatElec" data-form="login">
                <div class="form-group label-floating">
                    <label class="control-label"><span class="glyphicon glyphicon-user"></span>&nbsp;Nombre</label>
                    <input type="text" class="form-control" name="nombre-login" required="">
                </div>
                <div class="form-group label-floating">
                    <label class="control-label"><span class="glyphicon glyphicon-lock"></span>&nbsp;Contraseña</label>
                    <input type="password" class="form-control" name="clave-login" required="">
                </div>

                <p>¿Cómo iniciaras sesión?</p>

                <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" value="option1" checked="">
                        Usuario
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" value="option2">
                        Administrador
                    </label>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-raised btn-sm">Iniciar sesión</button>
                    <button type="button" class="btn btn-danger btn-raised btn-sm" data-dismiss="modal">Cancelar</button>
                </div>
                <div class="ResFormL" style="width: 100%; text-align: center; margin: 0;"></div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Configuración de Usuario -->
<?php if(isset($_SESSION['nombreUser'])): ?>
<div class="modal fade" id="ModalUpUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form class="modal-content FormCatElec" action="process/updateClient.php" method="POST" data-form="save" autocomplete="off">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Configuraciones</h4>
            </div>
            <div class="modal-body" id="UserConData">
                <!-- El contenido se cargará dinámicamente via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-info">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- Script para manejar la configuración del usuario -->
<script>
$(document).ready(function() {
    // Manejo del click en el botón de configuración
    $('.userConBtn').on('click', function(e) {
        e.preventDefault();
        var code = $(this).data('code');

        // Cargar datos del usuario via AJAX
        $.ajax({
            url: 'process/getUserData.php',
            method: 'POST',
            data: {code: code},
            success: function(response) {
                $('#UserConData').html(response);
                $('#ModalUpUser').modal('show');
            },

        });
    });

    // Manejo del formulario de configuración
    $(".FormCatElec").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();
        var url = form.attr('action');

       /*  $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                if(response.includes("success")) {
                    alert("Datos actualizados correctamente");
                    $('#ModalUpUser').modal('hide');
                    // Opcional: recargar la página para mostrar los datos actualizados
                    location.reload();
                } else {
                    alert("Error al actualizar los datos");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la actualización:", error);
                alert("Error al actualizar los datos");
            }
        }); */
    });
});
</script>
<?php endif; ?>

<!-- Script para la búsqueda en tiempo real -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-box');
        const searchResults = document.getElementById('searchResults');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value;
            if (query.length > 2) { // Realiza la búsqueda si la consulta tiene más de 2 caracteres
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
