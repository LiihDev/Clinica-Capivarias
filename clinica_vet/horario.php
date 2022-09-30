<?php

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: login.php"); exit;
}

if (isset($_GET['date'])) {
    $date = $_GET['date'];
}

$mysqli = new mysqli('localhost', 'root', '', 'petshop');
if(isset($_GET['date'])){
    $date = $_GET['date'];
    $stmt = $mysqli->prepare("SELECT * FROM agenda WHERE data = ?");
    $stmt->bind_param('s', $date);
    $agenda = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $agenda[] = $row['hora'];
            }
            $stmt->close();
        }
    }
}

if(isset($_POST['submit'])){
    $timeslot = $_POST['submit'];
    $id_user = $_SESSION['UsuarioID'];
    $stmt = $mysqli->prepare("SELECT * FROM agenda WHERE data = ? AND hora = ?");
    $stmt->bind_param('ss', $date, $timeslot);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            $_SESSION['msg'] = "<div class='alert alert-danger'>Horario já reservado</div>";
        }else{
            $stmt = $mysqli->prepare("INSERT INTO agenda (data, hora, usuario_id) VALUES (?,?,?)");
            $stmt->bind_param('sss', $date, $timeslot, $id_user);
            $stmt->execute();
            $_SESSION['msg'] = "<div class='alert alert-success'>Agendamento feito com sucesso</div>";
            $agenda[] = $timeslot;
            $stmt->close();
            $mysqli->close();
        }
    }
}

$duration = 60;
$cleanup = 0;
$start = "09:00";
$end = "22:00";

function timeslots($duration, $cleanup, $start, $end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();
    
    for($intStart = $start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }
        
        $slots[] = $intStart->format("H:iA")." - ". $endPeriod->format("H:iA");
        
    }
    
    return $slots;
    
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
    <title>Agende um horário</title>
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
    <div class="container2">
        <h1 class="text-center"><strong>Agendamento para: <?php echo date('d/m/Y', strtotime($date)); ?></strong></h1>
        <?php
        //se existir a variável msg, será impresso na tela a mensagem
        if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        // unset: destruir a variável
        unset($_SESSION['msg']);
        }
        ?>  
    <?php $timeslots = timeslots($duration, $cleanup, $start, $end); 
        foreach($timeslots as $ts){
    ?>
    <div class="horarios">
        <div class="form-group">
            <?php if(in_array($ts, $agenda)) { ?>
                <form method="POST">
                    <input type="submit" class='block' id="submit" name="submit" value="<?php echo $ts ?>">
                </form>
            <?php } else{ ?>
                <form method="POST">
                    <input class='btnagnd' type="submit" id="submit" name="submit" value="<?php echo $ts ?>">
                </form>

                
            <?php } ?>

    <?php } ?>
    
    </div>
    </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script 
    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min js" 
    integrity="sha384-Te51Qib027 qvyjSMfHjOMaLkfuWVxZxUPnCJA7I2mCWNIpG9mGCD8wGNicPD7Txa"
    crossorigin="anonymous"></script>
    </script>
</body>
</html>