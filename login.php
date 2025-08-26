<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style3.css">
</head>
<body>
    

  <div id="login">
        <div class="caixa">

          <a href="acessar.html">
            <h2>RifaNet</h2>
          </a>

          <h1>Entre na sua conta</h1>

          
          <form action= "conexaoLogin.php" method="POST">
                    
            <input type="email" id="email" placeholder="Digite seu e-mail" name="email" required><br>
            <input type="password" id="senha" placeholder="Digite sua senha" name="senha" required><br>
            <input type="submit" id="submit" name="submit"><br>
                        
          </form>
        </div>      
  </div>
  <script src="./js/login.js"></script>
</body>
</html>