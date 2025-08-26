<?php

if (isset($_POST['submit'])) { // Se o usuário enviar os dados ao apertar em submit

    include('conexao.php'); // Chama a conexão com o banco

    // Criação das variáveis com seus respectivos dados
    $nome = ucwords(strtolower($_POST['nome']));
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];

    // Verifica se o e-mail, telefone, CPF já estão cadastrados
    $sql_check = "SELECT * FROM tblUsuario WHERE usuEmail = ? OR usuTelefone = ? OR usuCpf = ?";
    $stmt_check = mysqli_prepare($conexao, $sql_check); // Prepara a consulta
    mysqli_stmt_bind_param($stmt_check, "sss", $email, $telefone, $cpf); // Liga as variáveis ao parâmetro
    mysqli_stmt_execute($stmt_check); // Executa a consulta
    $result_check = mysqli_stmt_get_result($stmt_check); // Obtém o resultado

    if (mysqli_num_rows($result_check) > 0) { // Se o número de linhas for maior que 0, email, telefone ou CPF já estão cadastrados
        $user = mysqli_fetch_assoc($result_check);
        if ($user['usuEmail'] === $email) {
            echo "<p>Este e-mail já está cadastrado.</p>";
        } elseif ($user['usuTelefone'] === $telefone) {
            echo "<p>Este telefone já está cadastrado.</p>";
        } elseif ($user['usuCpf'] === $cpf) {
            echo "<p>Este CPF já está cadastrado.</p>";
        }
    } else {
        // Inserção no banco de dados usando prepared statement (medida de segurança)
        $sql_insert = "INSERT INTO tblUsuario (usuNome, usuTelefone, usuCpf, usuNasc, usuEmail, usuSenha, usuCep, usuEndereco, usuNumero) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conexao, $sql_insert); // Prepara a consulta
        mysqli_stmt_bind_param($stmt_insert, "sssssssss", $nome, $telefone, $cpf, $data_nascimento, $email, $senha, $cep, $endereco, $numero); // Liga as variáveis aos parâmetros

        $resultado = mysqli_stmt_execute($stmt_insert); // Executa a consulta

        if ($resultado) { // Se a inserção no banco for bem-sucedida
            echo "<p>Cadastro realizado com sucesso! Você será redirecionado para a página de login.</p>";
            // Redireciona para login.php após 3 segundos
            header("refresh:2;url=login.php");
            exit(); // Sempre use exit após o header para garantir que o script pare de rodar
        } else { // Se houver erro na inserção
            echo "<p>Ocorreu um erro durante o cadastro. Por favor, tente novamente.</p>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro.com</title>
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<div class="container">

    <div class="form">

    <div class="form-header">

        <div class="title">
            <h1><a href="index.html">Cadastre-se</a></h1>
        </div>


            </div>

        <form action="cadastro.php" method="POST" class="input-group">

            <div class="input-box">
                <label for="firstname">Nome</label>
                <input id="firstname" type="text" name="nome" placeholder="Nome Completo" required>
            </div>

            <div class="input-box">
                <label for="telefone">Telefone</label>
                <input id="telefone" type="number" name="telefone" placeholder="(xx) xxxx-xxxx" required>
            </div>

            <div class="input-box">
                <label for="cpf">CPF</label>
                <input id="cpf" type="number" name="cpf" placeholder="xxx.xxx.xxx-xx" required>
            </div>

            <div class="input-box">
                <label for="nasc">Data de Nascimento</label>
                <input id="nasc" type="date" name="data_nascimento" required>
            </div>

            <div class="input-box">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-box">
                <label for="password">Senha</label>
                <input id="password" type="password" name="senha" placeholder="Digite sua senha" required>
            </div>

            <div class="input-box">
                <label for="cep">CEP</label>
                <input id="cep" type="number" name="cep" placeholder="CEP">
            </div>

            <div class="input-box">
                <label for="enderoco">Endereço</label>
                <input id="endereco" type="text" name="endereco" placeholder="Endereço">
            </div>

            <div class="input-box">
                <label for="numero">Número</label>
                <input id="numero" type="number" name="numero" placeholder="Número">
            </div>

            <div class="input-box">
                <input id="password" type="submit" name="submit">
            </div>

        </form>

<div class="login">
<h1>Já tem conta?<span><a href="login.php">Entrar</a></span></h1>
</div>

       
    </div>
</div>
    
  

</body>
</html>



