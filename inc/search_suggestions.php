<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "guardian.tale3";
$dbname = "tddiego";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el término de búsqueda
$term = $_GET['term'];

// Consulta para buscar productos
$sql = "SELECT CodigoProd, NombreProd, Precio, Imagen FROM producto WHERE NombreProd LIKE ?";
$stmt = $conn->prepare($sql);
$likeTerm = '%' . $term . '%';
$stmt->bind_param("s", $likeTerm);
$stmt->execute();
$result = $stmt->get_result();

// Devolver los resultados como JSON
$results = [];
while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}

echo json_encode($results);
?>
