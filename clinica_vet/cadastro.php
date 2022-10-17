<?php
session_start();

if (!isset($_SESSION)) session_start();

if (isset($_SESSION['UsuarioID']) AND ($_SESSION['UsuarioNivel'] < 2)) {
      header("Location: index.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link  rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"  crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <title>Cadastro</title>
</head>
<body>
    <?php
    //header caso o usuario não esteja logado
    if (!isset($_SESSION['UsuarioID'])) {
        echo "
        <header>
        <nav class='navbar navbar-expand-lg navbar-light'>
            <div class='container-fluid'>
                <a href='index.php'><img class='logo' src='img/Logo figma.png' alt='logo' width=180 height=70></a> 
            </div>
        </nav>
        </header>";
    }

    //header caso o usuario seja adm
    elseif (isset($_SESSION['UsuarioID']) && ($_SESSION['UsuarioNivel'] == 2)) {
        echo "
        <header>
        <nav class='navbar navbar-expand-lg navbar-light'>
            <div class='container-fluid'>
                <a href='index.php'><img class='logo' src='img/Logo figma.png' alt='logo' width=180 height=70></a> 
                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNavAltMarkup' aria-controls='navbarNavAltMarkup' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
                </button>
                <div class='collapse navbar-collapse' id='navbarNavAltMarkup'>
                <div class='navbar-nav'>
                    <a class='nav-link' href='petsadm.php'>Pets</a>
                    <a class='nav-link' href='agenda.php'>Agendamento</a>
                    <a class='nav-link' href='usuarios.php'>Usuários</a>
                    <a class='nav-link' href='edit_user.php'>Meu perfil</a>
                </div>
            </div>
            </div>
        </nav>
        </header>";
    }
    ?>
    <main>
        <div class="login-container">
            <div class="login-info-container">
                <h1 class="title">Cadastro</h1>
            <?php
            //se existir a variável msg, será impresso na tela a mensagem
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                // unset: destruir a variável
                unset($_SESSION['msg']);
            }
            ?>

            <form class="input-container" action="proc_cad.php" method="POST">
                <input class="input" type="text" name="nome" placeholder="Nome completo"   required> 

                <input class="input" type="text" name="doc" placeholder="CPF ou CNPJ"   required> 

                <input class="input" type="email" name="email" placeholder="E-mail"  required> 

                <input class="input" type="password" name="senha" placeholder="Senha" minlength="6"  required> 
                <input class="btn" type="submit" value="Cadastrar">
                <?php
                    if (!isset($_SESSION['UsuarioID'])) {
                        echo '<p>Já possui uma conta? <a class="span" href="login.php">Login</a></p>';
                    }
                ?>
            </form>
            </div>
            <img class="image-container" src="img/adote.png" alt="um casal com animais adotados">
        </div>
    </main>


</body>
</html>
