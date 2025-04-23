<?php
require_once 'bd_conexao.php';
session_start()
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpineAqui</title>
</head>
<body>


<h1>Opine Aqui - Logon da Empresa</h1>

<h2>Logon Empresa</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name='empresa_logon' id='empresa_logon'>
    <label for="empresa_email">E-mail:</label>
    <input type="text" name="empresa_email" id="empresa_email" required><br>   
    <label for="empresa_senha">Senha:</label>
    <input type="password" name="empresa_senha" required><br>
    <input type="submit" name="submit" value="Enviar"><br>
</form>

<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["empresa_email"]) && isset($_POST["empresa_senha"]) ) {

        $logon_status = logon_empresa($_POST["empresa_email"], $_POST["empresa_senha"]);

        if ($logon_status) {
            echo "Login realizado com sucesso! Você será redirecionado em instantes. <br><br>";
            echo "<script>
                setTimeout(function() {
                window.location.href = 'empresa_dados.php'},3000);
                </script>";
        }
        else {
            echo "Login ou senha incorretos. Tente novamente.";
        }
    }
}
?>

<br><br>
 

</body>
</html>