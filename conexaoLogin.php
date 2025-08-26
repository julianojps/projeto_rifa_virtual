<?php
    session_start(); // Inicia uma sessão 

    // Se existir submit
    if(isset($_POST['submit'])) {

        // Inclui o arquivo de conexão com o banco de dados
        include('conexao.php');
        
        // Define as variáveis a partir do formulário
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Verifica se as variáveis foram definidas corretamente
        if(empty($email) || empty($senha)) {
            header('Location: login.php');
            exit();
        }

        // Prepara e executa a consulta
        $sql_check = "SELECT * FROM tblUsuario WHERE usuEmail = ? AND usuSenha = ?";
        $stmt_check = mysqli_prepare($conexao, $sql_check); // Prepara a consulta
        mysqli_stmt_bind_param($stmt_check, "ss", $email, $senha); // Liga as variáveis $email e $senha aos parâmetros
        mysqli_stmt_execute($stmt_check); // Executa a consulta
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) < 1) { // Verifica se não há resultados
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            unset($_SESSION['nome']);

            header('Location: login.php');
            exit();
        } else { // Se o usuário for encontrado
            $usuario = mysqli_fetch_assoc($result_check); // Obtém os dados do usuário
            $_SESSION['email'] = $usuario['usuEmail'];
            $_SESSION['senha'] = $usuario['usuSenha'];
            $_SESSION['nome'] = $usuario['usuNome']; // Salva o nome do usuário na sessão
            
            header('Location: home.html'); // Direciona para home.php
            exit();
        }
    } else {
        header('Location: login.php');
        exit();
    }
?>
