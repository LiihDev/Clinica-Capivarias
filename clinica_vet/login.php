<?php
session_start();

if (!isset($_SESSION)) session_start();

if (isset($_SESSION['UsuarioID'])) {
      header("Location: index.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <title>Login</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a href="index.php"><img class='logo' src="img/Logo figma.png" alt="logo" width=180 height=70></a> 
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
            </div>
          </nav>
    </header>
    <main>
        <div class="login-container">
            <div class="login-info-container">
                <h2 class="title">Login</h2>
        <form class="inputs-container" action="proc_log.php" method="POST">

            <?php
             //se existir a variável msg, será impresso na tela a mensagem
             if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                // unset: destruir a variável
                unset($_SESSION['msg']);
            }
            ?>

            <input class="input" type="email" name="email" placeholder="Email"  required> 
            
            <input class="input" type="password" name="senha" placeholder="Senha"  required>
            <input class="btn" type="submit" value="Login" name="login">
            <p>Não possui uma conta? <a class="span" href="cadastro.php">Cadastre-se</a></p>
        </form>
        </div>
        <img class="image-container" src="img/cat.png" alt="um gato e um cachorro juntos">
    </div>
    </main>
</body>
</html>