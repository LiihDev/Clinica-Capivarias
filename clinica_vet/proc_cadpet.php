<?php	
session_start();
    include_once("conexao.php");
    $nivel = $_SESSION['UsuarioNivel'];
        if($nivel < 2){
            $id = $_SESSION['UsuarioID'];
        }
        else{
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        }
        
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

    $result_usuario = "INSERT INTO pet (nome, idade, especie, raca, sexo, peso, castracao, id_usuario) VALUES ('$nome', '$idade','$especie', '$raca', '$sexo', '$peso', '$castracao', '$id')";
    try{
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        if(mysqli_insert_id($conn)){
            if($nivel < 2){
                $_SESSION['msg'] = '<p class="msg">Pet cadastrado com sucesso!</p>';
                header('Location:pets.php'); 
            }
            else{
                $_SESSION['msg'] = '<p class="msg">Pet cadastrado com sucesso!</p>';
                header('Location:edit_useradm.php?id=' . $id);
            }
        }
     }
     catch(Exception $e){
        if($nivel < 2){
        $_SESSION['msg'] = '<p class="msgerro">Não foi possível cadastrar o Pet. Tente mais tarde</p>';
        header('Location:pets.php');
        }
        else{
            $_SESSION['msg'] = '<p class="msgerro">Não foi possível cadastrar o Pet. Tente mais tarde</p>';
        header('Location:edit_useradm.php?id=' . $id . '');
        }
    }
?>