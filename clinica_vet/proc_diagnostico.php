<?php	
session_start();
    include_once("conexao.php");

    $id_pet = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $descricao = filter_input(INPUT_POST,'descricao', FILTER_SANITIZE_STRING);
    $data_emissao = filter_input(INPUT_POST,'data_emissao', FILTER_SANITIZE_STRING);

    $result_usuario = "INSERT INTO diagnostico (data_emissao, descricao, id_pet) VALUES ('$data_emissao', '$descricao', '$id_pet')";
    try{
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        if(mysqli_insert_id($conn)){
            $_SESSION['msg'] = '<p class="msg">Adicionado com sucesso!</p>';
             header('Location:edit_diagnostico.php?id=' . $id_pet);
        }
     }
     catch(Exception $e){
        $_SESSION['msg'] = '<p class="msgerro">Não foi possível adicionar. Tente mais tarde!</p>';
         header('Location:edit_diagnostico.php?id=' . $id_pet);
     }
?>
