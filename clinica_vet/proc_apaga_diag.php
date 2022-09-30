<?php
session_start();

include_once("conexao.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){
    $result_usuario = "DELETE FROM diagnostico WHERE id='$id'";
    $resultado_usuario = mysqli_query($conn, $result_usuario);

    if(mysqli_affected_rows($conn)){
        $_SESSION['msg'] = "<p class='msg'>Apagado com sucesso!</p>";
        header("Location: petsadm.php");
    }else{
        $_SESSION['msg'] =  "<p class='msgerro'>Não foi possível apagar!</p>";
        header("Location: petsadm.php");
    }
}else{
    $_SESSION['msg'] =  "<p class='msgerro'>Necessário selecionar algo!</p>";
    header("Location: petsadm.php");
}
?>