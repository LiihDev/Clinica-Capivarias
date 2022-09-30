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

include_once("conexao.php");
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!isset($id)) {
    header("Location: login.php"); exit;
}

$result_users = "SELECT * FROM usuario WHERE id = '$id'";
$result_usuarios = mysqli_query($conn, $result_users);
$row_usuario = mysqli_fetch_assoc($result_usuarios);

$mysqli = new mysqli('localhost', 'root', '', 'petshop');
$stmt = $mysqli->prepare("SELECT * FROM pet WHERE id = $id");
$dados = array();

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dados[] = $row['nome'];
            $dados[] = $row['idade'];
            $dados[] = $row['especie'];
            $dados[] = $row['raca'];
            $dados[] = $row['sexo'];
            $dados[] = $row['peso'];
            $dados[] = $row['castracao'];
            $dados[] = $row['id'];

        }
        $stmt->close();
    }
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
    <title>Ficha do Pet</title>
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
    <main class="ficha">
        <h1 class="h1ficha">Ficha do pet</h1>
        <?php
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                // unset: destruir a variável
                unset($_SESSION['msg']);
            }
        ?>
    <div class="card">
        <div class="header-pet">
            <div class="nome-pet">
                <h1><?php echo $dados[0];?></h1>
            </div>
            <div class="especie-pet">
                <h3><?php echo $dados[3] . ', ' . $dados[2] . '.'?></h3>
            </div>
        </div>
        <div class="grid-container">
                <div class="idade-pet">
                     <h1>Idade</h1>
                    <p><?php echo $dados[1];?></p>
                </div>
                <div class="sexo-pet">
                     <h1>Sexo</h1>
                    <p><?php echo $dados[4];?></p>
                </div>
                <div class="peso-pet">
                    <h1>Peso</h1>
                    <p><?php echo $dados[5];?></p>
                </div>
        </div><br>
        <div class="container-castracao">
            <div class="castracao-pet">
                <h1>Animal Castrado?</h1> 
                <p><?php echo $dados[6];?></p>
            </div>
        </div>
    </div>


    <section class="info-vet">
    <section class='titulo'>
    <h1>Informações de consultas </h1>
    <?php
    if($_SESSION['UsuarioNivel'] == 2)
        echo "<a class='link' href='edit_diagnostico.php?id=" . $id . "'>Adicionar</a>";
    ?>
    </section>
    <?php
         $result_pet = "SELECT * FROM diagnostico WHERE id_pet = '$id'";
         $result_pets = mysqli_query($conn, $result_pet);

        if (mysqli_fetch_assoc($result_pets) == 0){
            echo "<strong><p> Oops, não há nada aqui!</p></strong>";
            exit;
        }


        $result_pets = mysqli_query($conn, $result_pet);
        while($row_pet = mysqli_fetch_assoc($result_pets)){
            echo '<section class="diagnostico">';
            echo '<img src="img/esteto.png" class="pata">';
            echo '<div class="infos">';
            echo "<p><strong>Info:</strong> " . $row_pet['descricao'] . "</p>";
            echo "<p><strong>Data:</strong> " . $row_pet['data_emissao'] . "</p>";
            echo "</div>";
            echo '</section>';
        }
    ?>
    </section>
</main>
</body>
</html>