<?php
session_start();
require_once "../library/configServer.php";
require_once "../library/consulSQL.php";

if (!empty($_SESSION['carro'])) {
    $suma = 0;
    $sumaA = 0;
    $message = "¡Nuevo pedido!\n\n";

    foreach ($_SESSION['carro'] as $codeProd) {
        $consulta = ejecutarSQL::consultar("SELECT * FROM producto WHERE CodigoProd='" . $codeProd['producto'] . "'");
        while ($fila = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
            $pref = number_format(($fila['Precio'] - ($fila['Precio'] * ($fila['Descuento'] / 100))), 2, '.', '');
            $subtotal = $pref * $codeProd['cantidad'];
            $suma += $subtotal;
            $sumaA += $codeProd['cantidad'];

            // Construir el enlace a la imagen con el dominio público
            $imageURL = "http://www.tudominio.com/assets/img-products/" . $fila['Imagen'];
            $message .= "Nombre: {$fila['NombreProd']}\n";
            $message .= "Precio: {$pref}\n";
            $message .= "Cantidad: {$codeProd['cantidad']}\n";
            $message .= "Subtotal: {$subtotal}\n";
            $message .= "Imagen: $imageURL\n\n";
        }
        mysqli_free_result($consulta);
    }

    $message .= "Total: S/. " . number_format($suma, 2) . "\n";
    $message .= "Cantidad total de productos: " . $sumaA . "\n";

    // Enviar mensaje de WhatsApp
    $phoneNumber = "989787403";
    $whatsappURL = "https://api.whatsapp.com/send?phone=51" . $phoneNumber . "&text=" . urlencode($message);
    header("Location: $whatsappURL");
    exit();
} else {
    echo '<p class="text-center text-danger lead">El carrito de compras está vacío</p><br>';
    echo '<a href="../product.php" class="btn btn-primary btn-lg btn-raised"><i class="fas fa-shopping-cart"></i> Ir a Productos</a>';
}
?>
