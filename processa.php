
<?php 

include_once("conexao.php");

        if($_POST) {
            $senha = $_POST['senha'];
            $confirma_senha = $_POST['confirma_senha'];
        if ($senha == "") {
            echo "<span class='aviso'><b>Aviso</b>: Senha não foi alterada!</span>";
        } else if ($senha <> $confirma_senha) {
            echo "<span class='erro'><b>Erro</b>: As senhas não conferem!</span>";
        } else {
            $nome = filter_input(INPUT_POST,'nome', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_EMAIL);
            $senha = filter_input(INPUT_POST,'senha', FILTER_SANITIZE_STRING);
            $cripto = sha1($senha);
            $consulta = $mysqli -> query ("select email from usuarios where email= '$cripto'");
            $result = $consulta-> fetch_all(PDO::FETCH_ASSOC);

            if ($consulta -> num_rows == 1) {

              echo "<span class='erro'><b>Erro</b>: Email já cadastrado!</span>";
            } else {


// echo "nome :$nome <br/>";
// echo "email :$email <br/>";
// echo "senha :$senha <br/>";
$result_usuario="INSERT INTO usuarios (nome ,email ,senha, data_cadastro) VALUES ('$nome','$email','$cripto',NOW())";
$resultado_usuario = mysqli_query($mysqli,$result_usuario);


            echo"<span class='aviso'><b>Cadastro realizado com sucesso!!<b></span	>";
          
          }
            


        }
     
    }


?>












































//$id=0;
//$nome=$_POST['nome'];
//$email=$_POST['email'];
//$senha=$_POST['senha'];

//$sql=$mysqli->prepare("insert into cadastro values (?,?,?,?)");

//$sql->bind_param("issss",$id,$nome,$email,$senha);

//$sql->execute();

//$sql->store_result();

//$result=$sql->affected_rows;

//if($result > 0){
  //  echo "Dados Inseridos com Sucesso!";
//}else{
  //  echo "Houve um erro";
//}