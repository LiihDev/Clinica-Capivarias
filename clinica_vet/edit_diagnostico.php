<?php
session_start();
include_once("conexao.php");

if (!isset($_SESSION)) session_start();

  // Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < 2)) {
      // Destrói a sessão por segurança
      session_destroy();
      // Redireciona o visitante de volta pro login
      header("Location: login.php"); exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$result_users = "SELECT * FROM pet WHERE id = '$id'";
$result_usuarios = mysqli_query($conn, $result_users);
$row_usuario = mysqli_fetch_assoc($result_usuarios);
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
    <title>Adicionar descrição</title>
</head>
<body>
<?php
    //header caso o usuario seja adm
    if (isset($_SESSION['UsuarioID']) && ($_SESSION['UsuarioNivel'] == 2)) {
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

    //header caso o usuario seja comum
    else{
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
                    <a class='nav-link' href='pets.php'>Meus Pets</a>
                    <a class='nav-link' href='agenda.php'>Agendamento</a>
                    <a class='nav-link' href='edit_user.php'>Meu Perfil</a>
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
            <h1 class="title">O que foi realizado na consulta?</h1>
        <?php
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                // unset: destruir a variável
                unset($_SESSION['msg']);
            }
        ?>
        <form  class="input-container" method="POST" action="proc_diagnostico.php">
            <input type="hidden" name="id" value="<?php echo $row_usuario['id']; ?>">
            <input class="input" type="text" name="descricao" placeholder="Adicionar descrição" required>
            <input class="input" type="date" name="data_emissao" placeholder="Data da consulta" required>
            <input class="btn" type="submit" value="Adicionar" name="editar">
        </form>
    </div>
        <img class="image-container" src="img/vet.png" alt="um veterinario">
    </div>
    </main>
</body>