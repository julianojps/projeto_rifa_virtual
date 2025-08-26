<?php

$servername = "localhost";
$database = "rifa_db";
$username = "root";
$password = "";

// Dados recebidos via POST
$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$email = $_POST['email'] ?? '';
$chave_pix = $_POST['chave_pix'] ?? '';
$opcoes = $_POST['opcoes'] ?? '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valor = $_POST["conteudo"] ?? '';
   // echo "Valor recebido: " . htmlspecialchars($valor);
 //   echo $nome;
 
}

  // Create connection
$conn = new mysqli($servername, $username, $password, $database);



// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO tbl_pagamento (numero, dados_usuario, dados_pix, telefone, email, opcao_pix) 
        VALUES (?, ?, ?, ?, ?, ?)";

// Preparar a consulta
$stmt = $conn->prepare($sql);

// Verificar se a preparação foi bem-sucedida
if ($stmt === false) {
    die('Error preparing the SQL statement: ' . $conn->error);
}

// Vincular as variáveis aos parâmetros da consulta
$stmt->bind_param("ssssss", $valor, $nome, $chave_pix, $telefone, $email, $opcoes);

// Executar a consulta
if ($stmt->execute()) {
    echo "Por favor, escaneie o QR Code abaixo e realize o pagamento para validar sua escolha.!";
} else {
    echo "Erro ao inserir registro: " . $stmt->error;
}

// Fechar a declaração e a conexão
$stmt->close();
$conn->close();

// Criar conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Buscar números cadastrados no banco de dados

$conn = new mysqli($servername, $username, $password, $database);
$QUERY = "SELECT numero FROM tbl_pagamento";
$executa_query = mysqli_query($conn, $QUERY);
$conta_linhas = mysqli_num_rows($executa_query);
?><?php
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Definição do tempo de sorteio (3 horas = 10800 segundos)
$duracao_sorteio = 30000; // 3 horas
// Buscar o último sorteio
$sql = "SELECT numero_sorteado, data_sorteio FROM sorteios ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$agora = time();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ultimo_sorteio = strtotime($row['data_sorteio']);
    $numero_sorteado = $row['numero_sorteado'];
    $proximo_sorteio = $ultimo_sorteio + $duracao_sorteio;
} else {
    // Caso não haja sorteio anterior, definir um horário de referência
    $proximo_sorteio = $agora + $duracao_sorteio;
    $numero_sorteado = "Nenhum ainda";
}

// Se já passou do tempo, fazer um novo sorteio
if ($agora >= $proximo_sorteio) {
    $numero_sorteado = rand(1, 50);
    $data_sorteio = date("Y-m-d H:i:s", $agora);
    $sql = "INSERT INTO sorteios (numero_sorteado, data_sorteio) VALUES ($numero_sorteado, '$data_sorteio')";
    $conn->query($sql);

    // Atualizar o próximo sorteio
    $proximo_sorteio = $agora + $duracao_sorteio;
}
// Buscar os dados dos ganhadores na tbl_pagamento
$sql_ganhadores = "SELECT dados_usuario, numero, telefone, email, dados_pix, opcao_pix, hora_aposta FROM tbl_pagamento WHERE numero = '$numero_sorteado'";
$result_ganhadores = $conn->query($sql_ganhadores);

// Verifica se houve erro na query
if (!$result_ganhadores) {
    die("Erro na consulta SQL: " . $conn->error);
}

if ($result_ganhadores->num_rows > 0) {
    while ($row = $result_ganhadores->fetch_assoc()) {
        $dados_usuario = $row['dados_usuario'];
        $numero = $row['numero'];
        $telefone = $row['telefone'];
        $email = $row['email'];
        $data_sorteio = $row['hora_aposta'];
        $chave_pix = $row['dados_pix'];
        $opcoes_chave_pix = $row['opcao_pix']; // Ajuste aqui (o nome do campo na query é 'opcoes')
      //  $data_sorteio = date("Y-m-d H:i:s"); // Data do sorteio atual

        // Verifica se o ganhador já está na tbl_ganhadores para evitar duplicação
        $sql_verifica = "SELECT id FROM tbl_ganhadores WHERE dados_usuario = '$dados_usuario' AND numero = '$numero'";
        $resultado_verifica = $conn->query($sql_verifica);

        // Verifica se a consulta de verificação falhou
        if (!$resultado_verifica) {
            die("Erro na consulta de verificação: " . $conn->error);
        }

       // if ($resultado_verifica->num_rows == 0) {
            // Se não existir, insere o ganhador na tbl_ganhadores
            $sql_inserir = "INSERT INTO tbl_ganhadores (dados_usuario, numero, telefone, email, chave_pix, opcoes_chave_pix, data_sorteio) 
                            VALUES ('$dados_usuario', '$numero', '$telefone', '$email', '$chave_pix', '$opcoes_chave_pix', '$data_sorteio')";

            if (!$conn->query($sql_inserir)) {
                die("Erro ao inserir ganhador: " . $conn->error);
          //  }
        }
    }
   
} 

$conn->close();



