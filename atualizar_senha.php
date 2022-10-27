<?php
session_start();
ob_start();
include_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    
    $chave = filter_input(INPUT_GET , 'chave' , FILTER_DEFAULT);
     if(!empty($chave)) {
        var_dump($chave);

        $query_user = "SELECT id FROM usuarios WHERE recuperar_senha = recuperar_senha LIMIT 1";

    $result_user = $conn->prepare($query_user);
    $result_user -> bindParam(":recuperar_senha",$chave, PDO::PARAM_STR);
    $result_user -> execute();

    if($result_user->rowCount() != 0){}else{

                    echo "<b>Aviso</b> erro!! link invalido!";


    }
     }
    
    ?>
</body>
</html> 