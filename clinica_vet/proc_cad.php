<?php	
session_start();
    include_once("conexao.php");

    $nome = filter_input(INPUT_POST,'nome', FILTER_SANITIZE_STRING);
    $doc = filter_input(INPUT_POST,'doc', FILTER_SANITIZE_STRING);
       if(validarcpf($doc) == false && validarcnpj($doc) == false){
        $_SESSION['msg'] = '<p class="msgerro">Documento invalido!</p>';
        header('Location:cadastro.php');
        die;
       }
    $email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST,'senha', FILTER_SANITIZE_STRING);
    $criptografada = md5($senha);

    $result_usuario = "INSERT INTO usuario (nome, email, senha, documento) VALUES ('$nome', '$email', '$criptografada', '$doc')";
    try{
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        if(mysqli_insert_id($conn)){
            $_SESSION['msg'] = '<p class="msg">Usuário cadastrado com sucesso!</p>';
            header('Location:cadastro.php');
        }
     }
     catch(Exception $e){
        $_SESSION['msg'] = '<p class="msgerro">Não foi possível cadastrar o usuário. Tente mais tarde!</p>';
        header('Location:cadastro.php');
     }


    //validar o doc
    function validarcpf($doc){

        if (strlen($doc) != 11 ||  preg_match('/([0-9])\1{10}/', $doc) || is_numeric($doc) == false) {
            $_SESSION['msg'] = '<p>Documento invalido!</p>';
            header('Location:cadastro.php');
        }
        else{        
            for ($t = 9; $t < 11; $t++) {
                
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $doc[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;


                if ($doc[$c] != $d) {
                    $_SESSION['msg'] = '<p>Documento invalido!</p>';
                    header('Location:cadastro.php');
                    return false;
                }
            }
            return true;
        }
    }

    function validarcnpj($doc){

        if (strlen($doc) != 14 ||  preg_match('/([0-9])\1{13}/', $doc) || is_numeric($doc) == false) {
            $_SESSION['msg'] = '<p>Documento invalido!</p>';
            header('Location:cadastro.php');
        }
        else{       
            //verificar o primeiro digito     
            for ($soma = 0, $i = 0, $j = 5; $i < 12; $i++) {
                $soma += $doc[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }
            
            $soma = ((10 * $soma) % 11) % 10;

            if ($doc[$i] != $soma) {
                $_SESSION['msg'] = '<p>Documento invalido!</p>';
                header('Location:cadastro.php');
                return false;
            }
            

            //verificar o segundo digito
            for ($soma = 0, $i = 0, $j = 6; $i < 13; $i++) {
                $soma += $doc[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }
            
            $soma = ((10 * $soma) % 11) % 10;
            
            if ($doc[$i] != $soma) {
                $_SESSION['msg'] = '<p>Documento invalido!</p>';
                header('Location:cadastro.php');
                return false;
            }
            return true;
        }
    }
?>