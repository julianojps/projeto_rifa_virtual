<?php
    session_start(); // Certifique-se de que está escrito corretamente

    if(!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
        // Se a sessão não estiver configurada, redireciona para o login
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        unset($_SESSION['nome']);
        header('Location: login.php');
        exit(); // Sempre use exit após o header para garantir que o script pare de rodar
    }
    $logado = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de rifas online para gerenciamento de rifas e informações do usuário.">
    <title>Minhas Rifas</title>
    <link rel="stylesheet" href="./css/conta.css">
</head>
<body>
  
    <header>
      
        <div class="header-container">
          
            <h1><?php echo $logado ?></h1>
            <p>Situação: <span class="status">Pendente</span></p>
          
        </div>
      
    </header>

    <div class="main-container">
        
        <aside class="sidebar">
          
           <button class="btn add-btn">
                <span class="icon">▲</span>
                Adicionar endereço
            </button>
          
            <div class="address-fields">
              
                <input type="text" placeholder="Rua">
                <input type="text" placeholder="Número">
                <input type="text" placeholder="Cidade">
                <input type="text" placeholder="Estado">
                <input type="text" placeholder="CEP">
              
            </div>
          
            <button class="btn create-raffle-btn">Criar novas rifas</button>
          
        </aside>

        
        <main class="main-content">
          
            <section class="search-section">
                <input type="text" class="search-bar" placeholder="Ex.: Computador">
            </section>

            <section class="filters-section">
              
                <select class="filter">
                    <option value="">Categoria</option>
                </select>
              
                <select class="filter">
                    <option value="">Localização</option>
                </select>
              
                <select class="filter">
                    <option value="">Ordenar por</option>
                </select>
              
            </section>

            <section class="raffle-info">
              
                <h2>Minhas Rifas</h2>
                <p>Quantidade de anúncios: 0 anúncios</p>
                <p>Publicados nos últimos 90 dias</p>
              
            </section>

            <section class="raffle-area">
                <p class="no-content">Ainda não há rifa ativa.</p>
            </section>
          
        </main>
      
 </div>
   
</body>
</html>