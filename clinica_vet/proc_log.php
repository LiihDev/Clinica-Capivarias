<?php
session_start();
    include_once("conexao.php");
    
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    // $senha = $_POST['senha'];
    $login = $_POST['login'];

    if(isset($login)){

        $verifica = mysqli_query($conn, "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'");
        if (mysqli_num_rows($verifica)<=0){
            $_SESSION['msg'] = '<p class="msgerro">Login ou senha incorretos!</p>';
            header('Location:login.php');
        die();
        }
        else{
            //salva os dados encontrados numa variavel
            $resultado = mysqli_fetch_assoc($verifica);

            //Se a sessão não existir, inicia uma
            if (!isset($_SESSION)) session_start();
            
            //Salva os dados encontrados na sessão
            $_SESSION['UsuarioID'] = $resultado['id'];
            $_SESSION['UsuarioNome'] = $resultado['nome'];
            $_SESSION['UsuarioNivel'] = $resultado['nivel_acesso'];

            //redireciona pra outra pagina
            header("Location: index.php");
        }
    }
?>