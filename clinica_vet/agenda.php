<?php

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
include_once('conexao.php');

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID'])) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: login.php"); exit;
}

$id = $_SESSION['UsuarioID'];

// função cria agenda
function build_calendar($month, $year){

    // Primeiro vamos criar um array contendo as abreviações dos dias da semana.
    $daysOfWeek = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');

    // Em seguida, vamos configurar algumas variáveis ​​usando o mês e ano que foram passados ​​como argumentos para esta função.

    // Qual é o primeiro dia do mês em questão?
    $firstDayOfMonth = mktime(0,0,0, $month, 1, $year);

    // Quantos dias este mês contém?
    $numberDays = date('t', $firstDayOfMonth);

    // Recuperar algumas informações sobre o primeiro dia do
    // mês em questão.
    $dateComponents = getdate($firstDayOfMonth);

    // Qual é o nome do mês em questão?
    $monthName = $dateComponents['month'];

    // Qual é o valor do índice (0-6) do primeiro dia do
    // mês em questão.
    $dayOfWeek = $dateComponents['wday'];

    // Em seguida, começaremos a criar o layout da tabela em que os dados do calendário são exibidos.

    // Cria o abridor de tag de tabela e os cabeçalhos de dia
    $dateToday = date('Y-m-d');
    $prev_month = date("m", mktime(0,0,0, $month-1, 1, $year));
    $prev_year = date("Y", mktime(0,0,0, $month-1, 1, $year));
    $next_month = date("m", mktime(0,0,0, $month+1, 1, $year));
    $next_year = date("Y", mktime(0,0,0, $month+1, 1, $year));
    $calendar = "<section class='headcalendar'><h2>$monthName $year</h2>";
    $calendar .="<nav class='nav-pag nav-page2'>";
    $calendar.= "<a href='?month=$prev_month&year=$prev_year'>Mês passado</a>";
    $calendar.= "<a href='?month=".date('m')."&year=".date('Y')."'>Mês atual</a>";
    $calendar.= "<a href='?month=$next_month&year=$next_year'>Proxímo Mês</a></section>";
    $calendar .="</nav>";
    $calendar.= "<br><table class='table table-bordered'>";
    $calendar.= "<tr>";

    // Cria o cabeçalho do calendário
    foreach($daysOfWeek as $day) {
        $calendar.= "<th class='header'>$day</th>";
    }

    // Cria o resto do calendário
    // Inicia o contador de dias, começando com o 1º.
    $calendar .= "<tr></tr>";
    $currentDay = 1;

    // A variável $dayOfWeek é usada para
    // assegurar que o calendário
    // display consiste em exatamente 7 colunas.
    if ($dayOfWeek > 0) {
        for ($i=0; $i < $dayOfWeek; $i++) { 
            $calendar .= "<td class='empty'></td>";
        }
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    while ($currentDay <= $numberDays) {
        //Sétima coluna (sábado) atingida. Inicie uma nova linha.
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "<tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $dayName = strtolower(date('I', strtotime($date)));
        $eventNum = 0;
        $today = $date == date('Y-m-d') ? 'today' : '';
        if ($date < date('Y-m-d')){
            $calendar .= "<td><h4>$currentDay</h4><button class='btn2 block'>N/D</button";
        } else {
            $calendar .= "<td class='$today'><h4>$currentDay</h4><a href='horario.php?date=$date' class='btn2'>Reservar</a></td>";
        }
          

        $calendar .= "</td>";
        // Contadores de incremento
        $currentDay++;
        $dayOfWeek++; 
    }

    //Complete a linha da última semana do mês, se necessário
    if($dayOfWeek < 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($i=0; $i < $remainingDays; $i++) { 
            $calendar .= "<td class='empty'></td>";
        }
    }

    $calendar .= "</tr></table>";

    return $calendar;
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
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
    <main class="agenda">
    <?php
        //se existir a variável msg, será impresso na tela a mensagem
        if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        // unset: destruir a variável
        unset($_SESSION['msg']);
        }
    ?>
    <div class="container"> 
        <?php
            $dateComponents = getdate();
            if (isset($_GET['month']) && isset($_GET['year'])) {
                $month = $_GET['month'];
                $year = $_GET['year'];
            }else {
                $month = $dateComponents['mon'];
                $year = $dateComponents['year'];
            }

            echo build_calendar($month, $year);
        ?> 
    </div> 
    <h1><strong>Próximas consultas</strong></h1>
    <?php
    if($_SESSION['UsuarioNivel'] == 2){
        echo 
        '<section class="info-agenda">
                <section class="titulo">
                </section>';
        $dateToday = date('Y-m-d');
        $result_agenda = "SELECT * FROM agenda WHERE data >= $dateToday   ";
        $result_agendas = mysqli_query($conn, $result_agenda);
    
        if (mysqli_fetch_assoc($result_agendas) == 0){
            echo "<strong><p> Oops, não há nada aqui!</p></strong>";
            exit;
        }
    
        $result_agendas = mysqli_query($conn, $result_agenda);
        while($row_agenda = mysqli_fetch_assoc($result_agendas)){
            echo '<section class="diagnostico">';
            echo '<div class="infos">';
            echo "<p><strong>Data:</strong> " . $row_agenda['data'] . "</p>";
            echo "<p><strong>Horário:</strong> " . $row_agenda['hora'] . "</p>";
            echo '<a class="span del" href="proc_apaga_agen.php?id=' . $row_agenda['id'] . '">Excluir</a>';
            echo "</div>";
            echo '</section>';
        }
    }
    else{
        echo 
        '<section class="info-agenda">
                <section class="titulo">
                </section>';
        $dateToday = date('Y-m-d');
        $result_agenda = "SELECT * FROM agenda WHERE data >= $dateToday AND usuario_id = $id ";
        $result_agendas = mysqli_query($conn, $result_agenda);
    
        if (mysqli_fetch_assoc($result_agendas) == 0){
            echo "<strong><p> Oops, não há nada aqui!</p></strong>";
            exit;
        }
    
        $result_agendas = mysqli_query($conn, $result_agenda);
        while($row_agenda = mysqli_fetch_assoc($result_agendas)){
            echo '<section class="diagnostico">';
            echo '<div class="infos">';
            echo "<p><strong>Data:</strong> " . $row_agenda['data'] . "</p>";
            echo "<p><strong>Horário:</strong> " . $row_agenda['hora'] . "</p>";
            echo '<a class="span del" href="proc_apaga_agen.php?id=' . $row_agenda['id'] . '">Excluir</a>';
            echo "</div>";
            echo '</section>';
        }
    }
    ?>
    </section>

    </main>
</body>
</html>