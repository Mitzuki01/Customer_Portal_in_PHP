
<?php 

include_once("conexao.php");

  if($_POST) {
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $confirma_senha = $_POST['confirma_senha'];
     if ($senha == "" || $nome == "") {
        echo "<span class='aviso'><b>Aviso</b>: Campo de nome ou senha não preenchido!</span>";
    } else if ($senha <> $confirma_senha) {
        echo "<span class='erro'><b>Erro</b>: As senhas não conferem!</span>";
    } else {
       $nome = filter_input(INPUT_POST,'nome', FILTER_SANITIZE_STRING);
       $email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
       $senha = filter_input(INPUT_POST,'senha', FILTER_SANITIZE_STRING);
       $cripto = sha1($senha);
       $consulta = $mysqli -> query ("select email from usuarios where email= '$email'");
       $result = $consulta -> fetch_array(PDO::FETCH_ASSOC);
            
       $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
       $sql_query = $mysqli -> query($sql_code);
       $quantidade = $sql_query->num_rows;

      if($quantidade > 0){

        echo "<span class='erro'><b>Erro</b>: Email já existente</span>";
          
      }else{
              //  echo "nome :$nome <br/>";
              //  echo "email :$email <br/>";
              //  echo "senha :$senha <br/>";
        $result_usuario="INSERT INTO usuarios (nome ,email ,senha, data_cadastro) VALUES ('$nome','$email','$cripto',NOW())";
        $resultado_usuario = mysqli_query($mysqli,$result_usuario);

           
      }              
    }        
  }
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
  

<div class="container">
<div class="background">

<div>
    
    <h3><img src="./img/mundoequipamentos.webp" alt=""></h3></div>
<div>

                 <h3>Cliente</h3>

<form action="" method="POST">
    
        <!--<div>    <label>First Name: </label> </div>-->
        <div>
            <input type="text" name="nome" placeholder="Your name..." class="text_area">
        </div>
        <div>
            <input type="email" name="email" placeholder="Your email..." class="text_area">
        </div>
        <!--<div><label>Your password: </label></div>-->
        <div>
            <input type="password" name="senha" placeholder="password..." class="text_area" id="senha">
        </div>
        <div>
            <input type="password" name="confirma_senha" placeholder="confirm your password..." class="text_area" id="senha">
        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<script src="js/script.js"></script>

        
        <div >
             <input type="submit" name="subject" value="REGISTRATION" class="button">
        </div> 


        
        <div>
            <label for="">Já tem uma conta? <a href="index.php" class="link">Login</a></label>
        </div>


       
    </form>
</div>

</div>
  
 
 </form>

</div>


</body>
</html>




