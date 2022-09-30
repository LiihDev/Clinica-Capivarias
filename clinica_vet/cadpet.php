<?php
session_start();
if (!isset($_SESSION)) session_start();

  // Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
      // Destrói a sessão por segurança
      session_destroy();
      // Redireciona o visitante de volta pro login
      header("Location: login.php"); exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/style2.css">
    
    <title>Cadastro Pets</title>

    <link  rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"  crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
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
    <main >
        <div class="loginpet-container">
            <div class="loginpet-info-container">
                <h1 class="title">Cadastro Pet</h1>
            <form class="inputpet-container"  action="proc_cadpet.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input class="input" type="text" name="nome" placeholder="Nome" required>
                
                <div class="input-check2">
                    <input class="input input2" type="number" name="idade" placeholder="Idade" required>
                    <input type="radio" name="idade1" value="Ano(s)" required>
                    <label>Ano(s)</label>
                    <input type="radio" name="idade1" value="Mês(es)" required>
                    <label>Mês(es)</label>
                </div> 
                
                <input class="input" type="text" name="raca" placeholder="Raça" required>
                
                
                <div class="input-check">
                    <label class='labelpet'>Sexo: </label>
                    <input type="radio" name="sexo" value="Fêmea" required>
                    <label>Fêmea</label>
                    <input type="radio" name="sexo" value="Macho" required>
                    <label>Macho</label>
                </div>

                <input class="input" type="text" name="especie" placeholder="Especie" required>
                
                <div class="input-check2">
                    <input class="input input2" type="number" name="peso" placeholder="Peso" required>
                    <input type="radio" name="peso1" value="Kg" required>
                    <label>Kg</label>
                    <input type="radio" name="peso1" value="G" required>
                    <label>G</label>
                </div>

                <div class="input-check">
                    <label class='labelpet'>Castrado? </label>
                    <input type="radio" name="castracao" value="Sim" required>
                    <label>Sim</label>
                    <input type="radio" name="castracao" value="Não" required>
                    <label>Não</label>
                </div>


                <button class="btn">Cadastrar Pet</button>
            </form>
        </div>
        <img class="image-container" src="img/cachorros.png" alt="Dois cachorros">
    </div>
    </main>
     

</body>
</html>