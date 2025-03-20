<?php
$phoneNumber = "989787403";
$message = "Hola, aquí está tu pedido.";
$pdfPath = "../pdfs/pedido.pdf";

$url = "https://api.whatsapp.com/send?phone=51" . $phoneNumber . "&text=" . urlencode($message);

header("Location: $url");
?>
