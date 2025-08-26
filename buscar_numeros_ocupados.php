<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "banco_de_dados");

if ($conn->connect_error) {
    die(json_encode([]));
}

$result = $conn->query("SELECT numero FROM rifas WHERE status = 'ocupado'");
$numerosOcupados = [];

while ($row = $result->fetch_assoc()) {
    $numerosOcupados[] = (int) $row['numero'];
}

echo json_encode($numerosOcupados);
$conn->close();
?>
