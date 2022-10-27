<?php
include('conexao.php');

if(isset($_POST['email']) || isset($_POST['senha'])) {

    if(strlen($_POST['email']) == 0) {
        echo "Email não identificado";
    } else if(strlen($_POST['senha']) == 0) {
        echo "Senha não identificada";
    } else {

        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
        $cripto = sha1($senha);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$cripto'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {
            
            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: painel.php");

        } else {
            echo "Falha ao logar! E-mail ou senha incorretos";
        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  



<div class="container">
<div class="background">

<div>
<!--     
        <h3><img src="./img/mundoequipamentos.webp" alt=""></h3></div> -->
<div>

                                    <h3>Cliente</h3>

<form action="" method="POST">
    
        <!--<div>    <label>First Name: </label> </div>-->
      <div>
            <input type="email" name="email" placeholder="Your email..." class="text_area">
      </div>
        <!--<div><label>Your password: </label></div>-->
      <div>
            <input type="password" name="senha" placeholder="password..." class="text_area" id="senha">
            <img id="olho" src="./img/eyes.png" class="lnr-eye">
      </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<script src="js/script.js"></script>
        
        <div >
             <input type="submit" name="subject" value="SIGN IN" class="button">
        </div> 

        
</form>

       

        <div>
             <label>Esqueceu a senha? <a class="link" href="senha.php">Redefinir senha</a></label>
        </div>
        <div>
             <label>Não tem cadastro?  <a class="link" href="cadastro.php">Cadastro</a></label>
        </div>
</div>

</div>
  
  </form>
</div>




</body>
</html>