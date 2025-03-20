<?php
session_start();
require_once "../library/configServer.php";
require_once "../library/consulSQL.php";
require_once "../library/fpdf.php";

if (!empty($_SESSION['carro'])) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Detalles del Pedido', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 10, 'Nombre', 1);
    $pdf->Cell(30, 10, 'Precio', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(30, 10, 'Subtotal', 1);
    $pdf->Ln();

    $suma = 0;
    foreach ($_SESSION['carro'] as $codeProd) {
        $consulta = ejecutarSQL::consultar("SELECT * FROM producto WHERE CodigoProd='" . $codeProd['producto'] . "'");
        while ($fila = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
            $pref = number_format(($fila['Precio'] - ($fila['Precio'] * ($fila['Descuento'] / 100))), 2, '.', '');
            $subtotal = $pref * $codeProd['cantidad'];
            $suma += $subtotal;

            $pdf->Cell(40, 10, $fila['NombreProd'], 1);
            $pdf->Cell(30, 10, $pref, 1);
            $pdf->Cell(30, 10, $codeProd['cantidad'], 1);
            $pdf->Cell(30, 10, $subtotal, 1);
            $pdf->Ln();
        }
        mysqli_free_result($consulta);
    }

    $pdf->Cell(100, 10, 'Total', 1);
    $pdf->Cell(30, 10, number_format($suma, 2), 1);

    $pdf->Output('F', '../pdfs/pedido.pdf');

    echo '<p class="text-center">Tu pedido ha sido confirmado. <a href="../pdfs/pedido.pdf" class="btn btn-primary btn-raised btn-lg">Descargar PDF</a></p>';
    echo '<p class="text-center"><a href="enviarwhatsapp.php" class="btn btn-success btn-raised btn-lg">Enviar PDF a WhatsApp</a></p>';
} else {
    echo '<p class="text-center text-danger lead">El carrito de compras está vacío</p>';
}
?>
