<?php
session_start();

include_once("conexao.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if(!empty($id)){
    $result_usuario = "DELETE FROM usuario WHERE id='$id'";
    $resultado_usuario = mysqli_query($conn, $result_usuario);

    if(mysqli_affected_rows($conn)){
        $_SESSION['msg'] = "<p class='msg'>Usuário apagado com sucesso</p>";
        header("Location: usuarios.php");
    }else{
        $_SESSION['msg'] =  "<p class='msgerro'>Não foi possível apagar o usuário</p>";
        header("Location: usuarios.php");
    }
}else{
    $_SESSION['msg'] =  "<p class='msgerro'>Necessário selecionar um usuário</p>";
    header("Location: usuarios.php");
}
?>