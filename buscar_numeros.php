<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rifa_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexão falhou: " . $conn->connect_error]));
}

$sql = "SELECT numero FROM numeros_escolhidos";
$result = $conn->query($sql);

$numerosEscolhidos = [];
while ($row = $result->fetch_assoc()) {
    $numerosEscolhidos[] = (int) $row["numero"];
}

$conn->close();
echo json_encode($numerosEscolhidos);
?>
