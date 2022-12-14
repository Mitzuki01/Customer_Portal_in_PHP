<?php
session_start();
ob_start();
include_once 'conexao.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './lib/vendor/autoload.php';
$mail = new PHPMailer(true);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
</head>

<body>
    <h1>Recuperar Senha</h1>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['SendRecupSenha'])) {
        //var_dump($dados);
        $query_usuario = "SELECT id, nome, gmail
                    FROM usuarios 
                    WHERE usuarios = email 
                    LIMIT 1";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bindParam(':usuarios', $dados['usuarios'], PDO::PARAM_STR);
       // $result_usuario->execute();

        if (($result_usuario) and ($result_usuario->rowCount() != 0)) {
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
            $chave_recuperar_senha = password_hash($row_usuario['id'], PASSWORD_DEFAULT);
            //echo "Chave $chave_recuperar_senha <br>";

            $query_up_usuario = "UPDATE usuarios 
                        SET recuperar_senha =:recuperar_senha 
                        WHERE id =:id 
                        LIMIT 1";
            $result_up_usuario = $conn->prepare($query_up_usuario);
            $result_up_usuario->bindParam(':recuperar_senha', $chave_recuperar_senha, PDO::PARAM_STR);
            $result_up_usuario->bindParam(':id', $row_usuario['id'], PDO::PARAM_INT);

            if ($result_up_usuario->execute()) {
                $link = "http://localhost/celke/atualizar_senha.php?chave=$chave_recuperar_senha";

                try {
                    /*$mail->SMTPDebug = SMTP::DEBUG_SERVER;*/
                    $mail->CharSet = 'UTF-8';
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.mailtrap.io';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'e3efb8755943d1';
                    $mail->Password   = 'fe84283081bb96';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 2525;

                    $mail->setFrom('atendimento@celke.com', 'Atendimento');
                    $mail->addAddress($row_usuario['usuario'], $row_usuario['nome']);

                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Recuperar senha';
                    $mail->Body    = 'Prezado(a) ' . $row_usuario['nome'] .".<br><br>Voc?? solicitou altera????o de senha.<br><br>Para continuar o processo de recupera????o de sua senha, clique no link abaixo ou cole o endere??o no seu navegador: <br><br><a href='" . $link . "'>" . $link . "</a><br><br>Se voc?? n??o solicitou essa altera????o, nenhuma a????o ?? necess??ria. Sua senha permanecer?? a mesma at?? que voc?? ative este c??digo.<br><br>";
                    $mail->AltBody = 'Prezado(a) ' . $row_usuario['nome'] ."\n\nVoc?? solicitou altera????o de senha.\n\nPara continuar o processo de recupera????o de sua senha, clique no link abaixo ou cole o endere??o no seu navegador: \n\n" . $link . "\n\nSe voc?? n??o solicitou essa altera????o, nenhuma a????o ?? necess??ria. Sua senha permanecer?? a mesma at?? que voc?? ative este c??digo.\n\n";

                    $mail->send();

                    $_SESSION['msg'] = "<p style='color: green'>Enviado e-mail com instru????es para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!</p>";
                    header("Location: index.php");
                } catch (Exception $e) {
                    echo "Erro: E-mail n??o enviado sucesso. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo  "<p style='color: #ff0000'>Erro: Tente novamente!</p>";
            }
        } else {
            echo "<p style='color: #ff0000'>Erro: Usu??rio n??o encontrado!</p>";
        }
    }

    if (isset($_SESSION['msg_rec'])) {
        echo $_SESSION['msg_rec'];
        unset($_SESSION['msg_rec']);
    }

    ?>

    <form method="POST" action="">
        <?php
        $usuario = "";
        if (isset($dados['usuarios'])) {
            $usuario = $dados['usuarios'];
        } ?>

        <label>E-mail</label>
        <input type="text" name="usuarios" placeholder="Digite o usu??rio" value="<?php echo $usuario; ?>"><br><br>

        <input type="submit" value="Recuperar" name="SendRecupSenha">
    </form>

    <br>
    Lembrou? <a href="index.php">clique aqui</a> para logar

</body>

</html>