<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    <?php include './inc/link.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .center-all-contens {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }
        .btn-lg {
            padding: 15px 25px;
            font-size: 1.25em;
            border-radius: 5px;
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .modal-header .close {
            color: #fff;
            opacity: 1;
        }
        .modal-footer {
            border-top: none;
            justify-content: space-between;
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
    </style>
</head>
<body id="container-page-index">
    <?php include './inc/navbar.php'; ?>
    <section id="container-pedido">
        <div class="container mt-5">
            <div class="page-header">
                <h1>PEDIDOS <small class="tittles-pages-logo">XTREME AI</small></h1>
            </div>
            <div class="row mt-4">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <?php
                        require_once "library/configServer.php";
                        require_once "library/consulSQL.php";
                        if ($_SESSION['UserType'] == "Admin" || $_SESSION['UserType'] == "User") {
                            if (isset($_SESSION['carro'])) {
                    ?>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-10 col-xs-offset-1">
                                <h3 class="text-center">Selecciona un método de pago</h3>
                                <img class="img-responsive center-all-contens" src="assets/img/credit-card.png" alt="Pago por banco">
                                <h4 class="text-center">
                                    <button class="btn btn-lg btn-success btn-block" data-toggle="modal" data-target="#PagoModalTran">
                                        <i class="fas fa-university"></i> Transacción Bancaria
                                    </button>
                                </h4>
                                <img class="img-responsive center-all-contens" src="assets/img/yape.jpg" alt="QR para pagos Yape">
                                <h2 class="text-center">
                                    <button class="btn btn-lg btn-success btn-block" data-toggle="modal" data-target="#PagoModalYape">
                                        <i class="fas fa-mobile-alt"></i> Confirmar Pago con Yape
                                    </button>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <?php
                            } else {
                                echo '<p class="text-center lead">No tienes pedidos pendientes de pago</p>';
                            }
                        } else {
                            echo '<p class="text-center lead">Inicia sesión para realizar pedidos</p>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para Pago con Yape -->
    <div class="modal fade" id="PagoModalYape" tabindex="-1" role="dialog" aria-labelledby="PagoModalYapeLabel">
        <div class="modal-dialog" role="document">
            <form class="modal-content FormCatElec" action="process/confirmcompra.php" method="POST" role="form" data-form="save">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="PagoModalYapeLabel">Pago por Yape</h4>
                </div>
                <div class="modal-body">
                    <p>Por favor, escanee el siguiente código QR con su aplicación de Yape para realizar el pago:</p>
                    <p>Después de realizar el pago, ingrese el número de operación y adjunte una captura del comprobante de pago.</p>
                    <div class="form-group">
                        <label>Número de Operacion</label>
                        <input class="form-control" type="text" name="NumDepo" placeholder="Número de Operacion" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Envío</label>
                        <select class="form-control" name="tipo-envio" data-toggle="tooltip" data-placement="top" title="Elige el tipo de envío">
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Recoger Por Tienda">Recoger por Tienda</option>
                            <option value="Envio Por Currier">Envío Gratis</option>
                        </select>
                    </div>
                    <input type="hidden" name="Cedclien" value="<?php echo $_SESSION['UserNIT']; ?>">
                    <div class="form-group">
                        <input type="file" name="comprobante">
                        <div class="input-group">
                            <input type="text" readonly class="form-control" placeholder="Seleccione la imagen del comprobante...">
                            <span class="input-group-btn input-group-sm">
                                <button type="button" class="btn btn-fab btn-fab-mini">
                                    <i class="fas fa-file-image"></i>
                                </button>
                            </span>
                        </div>
                        <p class="help-block"><small>Tipos de archivos admitidos: imágenes .jpg y .png. Máximo 5 MB</small></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm btn-raised" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm btn-raised">Confirmar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Pago por Transacción Bancaria -->
    <div class="modal fade" id="PagoModalTran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form class="modal-content FormCatElec" action="process/confirmcompra.php" method="POST" role="form" data-form="save">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pago por Transacción Bancaria</h4>
                </div>
                <div class="modal-body">
                    <?php
                        $consult1 = ejecutarSQL::consultar("SELECT * FROM cuentabanco");
                        if (mysqli_num_rows($consult1) >= 1) {
                            $datBank = mysqli_fetch_array($consult1, MYSQLI_ASSOC);
                    ?>
                    <p>Por favor, realice el depósito en la siguiente cuenta bancaria e ingrese el número de depósito que se le proporcionó.</p>
                    <p>
                        <strong>Nombre del banco:</strong> <?php echo $datBank['NombreBanco']; ?><br>
                        <strong>Número de cuenta:</strong> <?php echo $datBank['NumeroCuenta']; ?><br>
                        <strong>Nombre del beneficiario:</strong> <?php echo $datBank['NombreBeneficiario']; ?><br>
                        <strong>Tipo de cuenta:</strong> <?php echo $datBank['TipoCuenta']; ?><br>
                    </p>
                    <div class="form-group">
                        <label>Número de depósito</label>
                        <input class="form-control" type="text" name="NumDepo" placeholder="Número de depósito" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Envío</label>
                        <select class="form-control" name="tipo-envio" data-toggle="tooltip" data-placement="top" title="Elige el tipo de envío">
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Recoger Por Tienda">Recoger por Tienda</option>
                            <option value="Envio Por Currier">Envío Gratis</option>
                        </select>
                    </div>
                    <input type="hidden" name="Cedclien" value="<?php echo $_SESSION['UserNIT']; ?>">
                    <div class="form-group">
                        <input type="file" name="comprobante">
                        <div class="input-group">
                            <input type="text" readonly class="form-control" placeholder="Seleccione la imagen del comprobante...">
                            <span class="input-group-btn input-group-sm">
                                <button type="button" class="btn btn-fab btn-fab-mini">
                                    <i class="fas fa-file-image"></i>
                                </button>
                            </span>
                        </div>
                        <p class="help-block"><small>Tipos de archivos admitidos: imágenes .jpg y .png. Máximo 5 MB</small></p>
                    </div>
                    <?php
                        } else {
                            echo "Ocurrió un error: Parece que no se ha configurado las cuentas de banco";
                        }
                        mysqli_free_result($consult1);
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm btn-raised" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm btn-raised">Confirmar</button>
                </div>
            </form>
        </div>
    </div>

    <?php
        if ($_SESSION['UserType'] == "User") {
            $consultaC = ejecutarSQL::consultar("SELECT * FROM venta WHERE NIT='" . $_SESSION['UserNIT'] . "'");
            if (mysqli_num_rows($consultaC) >= 1) {
    ?>
    <div class="container mt-5">
        <div class="page-header">
            <h1>Mis Pedidos</h1>
        </div>
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Envío</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($rw = mysqli_fetch_array($consultaC, MYSQLI_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo $rw['Fecha']; ?></td>
                    <td>S/. <?php echo $rw['TotalPagar']; ?></td>
                    <td>
                        <?php
                            switch ($rw['Estado']) {
                                case 'Enviado':
                                    echo "En camino";
                                    break;
                                case 'Pendiente':
                                    echo "En espera";
                                    break;
                                case 'Entregado':
                                    echo "Entregado";
                                    break;
                                default:
                                    echo "Sin información";
                                    break;
                            }
                        ?>
                    </td>
                    <td><?php echo $rw['TipoEnvio']; ?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php
            } else {
                echo '<p class="text-center lead">No tienes ningún pedido realizado</p>';
            }
            mysqli_free_result($consultaC);
        }
    ?>
    <?php include './inc/footer.php'; ?>
</body>
</html>
