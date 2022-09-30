<?php
session_start();
include_once("conexao.php");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST,'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);

$result_user = "UPDATE usuario SET nome='$nome', email='$email' WHERE id='$id'";
$resultado_usuario = mysqli_query($conn, $result_user);

if(mysqli_affected_rows($conn)){
    $_SESSION['msg'] = '<p class="msg">Editado com sucesso!</p>';
    header('Location:edit_useradm.php?id=' . $id);
}else{
    $_SESSION['msg'] = '<p class="msgerro">Não foi possível editar!</p>';
    header('Location:edit_useradm.php?id=' . $id);
}

?>