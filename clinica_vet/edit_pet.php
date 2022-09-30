<?php
session_start();
include_once("conexao.php");
if (!isset($_SESSION)) session_start();

  // Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
      // Destrói a sessão por segurança
      session_destroy();
      // Redireciona o visitante de volta pro login
      header("Location: login.php"); exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$result_pet = "SELECT * FROM pet WHERE id = '$id'";
$result_pets = mysqli_query($conn, $result_pet);
$row_pet = mysqli_fetch_assoc($result_pets);

$idade = explode(" ", $row_pet['idade']);
$peso = explode(" ", $row_pet['peso']);
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
    <title>Editar pet</title>
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
    <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            // unset: destruir a variável
            unset($_SESSION['msg']);
        }
    ?>
        <div class="loginpet-container">
            <div class="loginpet-info-container">
                <h1 class="title">Editar Pet</h1>
            <form class="inputpet-container"  action="proc_edit_pet.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input class="input" type="text" name="nome" placeholder="Nome"  value="<?php echo $row_pet['nome']; ?>" required>
                
                <div class="input-check2">
                    <input class="input input2" type="number" name="idade" placeholder="Idade" value="<?php echo $idade[0]; ?>" required>
                    <?php
                    if($idade[1] == "Ano(s)"){
                        echo '<input type="radio" name="idade1" value="Ano(s)" checked required>';
                        echo '<label>Ano(s)</label>';
                    }
                    else{
                        echo '<input type="radio" name="idade1" value="Ano(s)" required>';
                        echo '<label>Ano(s)</label>';
                    }
                    if($idade[1] == "Mês(es)"){
                        echo '<input type="radio" name="idade1" value="Mês(es)" checked required>';
                        echo '<label>Mês(es)</label>';
                    }
                    else{
                        echo '<input type="radio" name="idade1" value="Mês(es)" required>';
                        echo '<label>Mês(es)</label>';
                    }
                    ?>
                </div> 
                
                <input class="input" type="text" name="raca" placeholder="Raça"  value="<?php echo $row_pet['raca']; ?>" required>
                
                
                <div class="input-check">
                    
                    <label class='labelpet'>Sexo: </label>
                    <?php
                    if($row_pet['sexo'] == "F"){
                        echo '<input type="radio" name="sexo" value="Fêmea" checked required>';
                        echo '<label>Fêmea</label>';
                    }
                    else{
                        echo '<input type="radio" name="sexo" value="Fêmea" required>';
                        echo '<label>Fêmea</label>';
                    }
                    if($row_pet['sexo'] == "M"){
                        echo '<input type="radio" name="sexo" value="Macho" checked required>';
                        echo '<label>Macho</label>';
                    }
                    else{
                        echo '<input type="radio" name="sexo" value="Macho" required>';
                        echo '<label>Macho</label>';
                    }
                    ?>
                </div>

                <input class="input" type="text" name="especie" placeholder="Especie" value="<?php echo $row_pet['especie']; ?>" required>
                
                <div class="input-check2">
                    <input class="input input2" type="number" name="peso" placeholder="Peso" value="<?php echo $peso[0]; ?>" required>
                    <?php
                    if($peso[1] == "Kg"){
                        echo '<input type="radio" name="peso1" value="Kg" checked required>';
                        echo '<label>Kg</label>';
                    }
                    else{
                        echo '<input type="radio" name="peso1" value="Kg" required>';
                        echo '<label>Kg</label>';
                    }
                    if($peso[1] == "G"){
                        echo '<input type="radio" name="peso1" value="G" checked required>';
                        echo '<label>G</label>';
                    }
                    else{
                        echo '<input type="radio" name="peso1" value="G" required>';
                        echo '<label>G</label>';
                    }
                    ?>
                </div>

                <div class="input-check">
                    <label class='labelpet'>Castrado? </label>
                    <?php
                    if($row_pet['castracao'] == "Sim"){
                        echo '<input type="radio" name="castracao" value="Sim" checked required>';
                        echo '<label>Sim</label>';
                    }
                    else{
                        echo '<input type="radio" name="castracao" value="Sim" required>';
                        echo '<label>Sim</label>';
                    }
                    if($row_pet['castracao'] == "Não"){
                        echo '<input type="radio" name="castracao" value="Não" checked required>';
                        echo '<label>Não</label>';
                    }
                    else{
                        echo '<input type="radio" name="castracao" value="Não" required>';
                        echo '<label>Não</label>';
                    }
                    ?>
                </div>


                <button class="btn">Editar</button>
            </form>
        </div>
        <img class="image-container" src="img/cachorros.png" alt="Dois cachorros">
    </div>
    </main>
</body>
</html>