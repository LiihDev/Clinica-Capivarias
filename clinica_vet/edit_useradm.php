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
$result_users = "SELECT * FROM usuario WHERE id = '$id'";
$result_usuarios = mysqli_query($conn, $result_users);
$row_usuario = mysqli_fetch_assoc($result_usuarios);
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
    <title>Editar Usuário</title>
</head>
<body>
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
        </header>
    <main>
    <div class="login-container">
        <div class="login-info-container">
            <h1 class="title">Editar Dados</h1>
        <?php
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                // unset: destruir a variável
                unset($_SESSION['msg']);
            }
        ?>
        <form  class="input-container" method="POST" action="proc_edit_useradm.php">
            <input type="hidden" name="id" value="<?php echo $row_usuario['id']; ?>">
            <input class="input" type="text" name="nome" placeholder="Nome" value="<?php echo $row_usuario['nome']; ?>"  required>
            <input disabled class="input" type="text" name="nome" placeholder="Nome" value="<?php echo $row_usuario['documento']; ?>">
            <input class="input" type="email" name="email" placeholder="E-mail" value="<?php echo $row_usuario['email']; ?>"  required>
        
            <input class="btn" type="submit" value="Editar" name="editar">
            <a class="span del" href="proc_apagar_user.php?id=<?php echo $row_usuario['id']?>">Excluir usuário</a>
        </form>
    </div>
    <img class="image-container" src="img/gato.png" alt="um gato e um rato">
    </div>
    </main>
</body>
</html>