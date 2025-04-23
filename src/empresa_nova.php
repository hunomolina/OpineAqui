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

<h1>Opine Aqui - Cadastrar nova Empresa</h1>

<h2>Cadastrar Empresa</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name='empresa_cadastrar' id='empresa_cadastrar'>
    <label for="empresa_cnpj">CNPJ:</label>
    <input type="text" name="empresa_cnpj" id="empresa_cnpj" required><br>
    <label for="empresa_nome">Nome da Empresa:</label>
    <input type="text" name="empresa_nome" id="empresa_nome" required><br>
    <label for="empresa_email">E-mail:</label>
    <input type="text" name="empresa_email" id="empres_email" required><br>
    <label for="empresa_descricao">Descrição:</label>
    <input type="text" name="empresa_descricao" id="empresa_descricao" required><br>
    <label for="empresa_senha">Senha:</label>
    <input type="password" name="empresa_senha" id="empresa_senha" required><br>
    <label for="empresa_endereco">Endereço:</label>
    <input type="text" name="empresa_endereco" id="empresa_endereco" required><br>
    <label for="empresa_atividade">Atividade:</label>
    <input type="text" name="empresa_atividade" id="empresa_atividade" required><br>
    <input type="submit" name="submit" value="Enviar"><br>
</form>


<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if(isset($_POST["logon_email"]) && isset($_POST["logon_senha"]) ) {

        $cadastro_status = cadastrar_empresa(
            $_POST["empresa_cnpj"],
            $_POST["empresa_email"], 
            $_POST["empresa_nome"], 
            $_POST["empresa_descricao"],
            $_POST["empresa_senha"],
            $_POST["empresa_endereco"],
            $_POST["empresa_atividade"]
        );

        if ($cadastro_status) {
            echo "Cadastro realizado com sucesso! Você será redirecionado em instantes. <br><br>";
            echo "<script>
                setTimeout(function() {
                window.location.href = 'empresa_dados.php'},3000);
                </script>";
        }
        else {}
    }
?>

</body>
</html>