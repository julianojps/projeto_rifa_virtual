<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rifa_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero = intval($_POST["numero"]);

    $check = $conn->prepare("SELECT numero FROM numeros_escolhidos WHERE numero = ?");
    $check->bind_param("i", $numero);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Erro: O número $numero já foi escolhido.";
    } else {
        $stmt = $conn->prepare("INSERT INTO numeros_escolhidos (numero) VALUES (?)");
        $stmt->bind_param("i", $numero);

        if ($stmt->execute()) {
            echo "Pagamento do número $numero confirmado!";
        } else {
            echo "Erro ao registrar pagamento.";
        }
    }
}

$conn->close();

