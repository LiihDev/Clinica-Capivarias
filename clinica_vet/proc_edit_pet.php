<?php	
session_start();
    include_once("conexao.php");
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        
    $nome = filter_input(INPUT_POST,'nome', FILTER_SANITIZE_STRING);
    $idade = filter_input(INPUT_POST,'idade', FILTER_SANITIZE_STRING);
        $idade1 = filter_input(INPUT_POST,'idade1', FILTER_SANITIZE_STRING);
        $idade = $idade . " " . $idade1;

    $raca = filter_input(INPUT_POST,'raca', FILTER_SANITIZE_STRING);
    $sexo = filter_input(INPUT_POST,'sexo', FILTER_SANITIZE_STRING);
    $especie = filter_input(INPUT_POST,'especie', FILTER_SANITIZE_STRING);
    $peso = filter_input(INPUT_POST,'peso', FILTER_SANITIZE_STRING);
        $peso1 = filter_input(INPUT_POST,'peso1', FILTER_SANITIZE_STRING);
        $peso = $peso . " " . $peso1;
    $castracao = filter_input(INPUT_POST,'castracao', FILTER_SANITIZE_STRING);

    $result_usuario = "UPDATE pet SET nome='$nome', idade='$idade', especie='$especie', raca='$raca', sexo='$sexo', peso='$peso', castracao='$castracao' WHERE id='$id'";
    try{
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        if(mysqli_affected_rows($conn)){
            if($nivel < 2){
                $_SESSION['msg'] = '<p class="msg">Pet editado com sucesso!</p>';
                header('Location:pets.php'); 
            }
            else{
                $_SESSION['msg'] = '<p class="msg">Pet editado com sucesso!</p>';
                header('Location:petsadm.php');
            }
        }
     }
     catch(Exception $e){
        if($nivel < 2){
        $_SESSION['msg'] = '<p class="msgerro">Não foi possível editar o Pet. Tente mais tarde</p>';
        header('Location:pets.php');
        }
        else{
            $_SESSION['msg'] = '<p class="msgerro">Não foi possível editar o Pet. Tente mais tarde</p>';
        header('Location:petsadm.php');
        }
    }
?>