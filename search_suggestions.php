<?php
include 'library/configServer.php';
include 'library/consulSQL.php';

$term = $_GET['term'] ?? '';

if (!empty($term)) {
    $consulta = ejecutarSQL::consultar("SELECT CodigoProd, NombreProd, Marca, Precio, Imagen FROM producto WHERE (NombreProd LIKE '%$term%' OR Marca LIKE '%$term%') AND Stock > 0 AND Estado='Activo' LIMIT 10");
    $resultados = [];

    while ($fila = mysqli_fetch_array($consulta, MYSQLI_ASSOC)) {
        $resultados[] = $fila;
    }

    echo json_encode($resultados);
} else {
    echo json_encode([]);
}
?>
