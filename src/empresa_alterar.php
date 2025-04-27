<?php
require_once 'bd_conexao.php';
session_start();
if (empty($_SESSION["empresa_id"])) {
    echo "Recurso não permitido. <br>";
    echo "<script>
        setTimeout(function() {
        window.location.href = 'index.php'},1000);
        </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpineAqui</title>
</head>



<body>

<h1>Opine Aqui - Alterar dados da empresa</h1>

<h2>Empresa: <? echo $_SESSION['empresa_nome']; ?></h2>

<a href="empresa_dados.php">Voltar</a><br>
<a href="empresa_logoff.php">Logoff</a><br>
<a href="#" onclick="inativar_empresa();">Inativar empresa na plataforma OpineAqui</a><br>

<br><br>


<?php
$empresas = dados_empresa($_SESSION['empresa_id']);
if ($empresas->num_rows > 0) {
    while ($row = $empresas->fetch_assoc()) {
        $cnpj = $row["cnpj"];
        $email = $row["email"];
        $nome = $row["nome"];
        $descricao = $row["descricao"];
        $senha = $row["senha"];
        $endereco = $row["endereco"];
    } 
} else {
    echo "Cadastro não localizados.<br>";
}
?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name='empresa_cadastrar' id='empresa_cadastrar'>
    <label for="empresa_email">E-mail:</label>
    <input type="text" name="empresa_email" id="empres_email" value="<?php echo $email; ?>" required><br>
    <label for="empresa_senha">Nova Senha:</label>
    <input type="password" name="empresa_senha" id="empresa_senha" value="<?php echo $senha; ?>" required><br><br>

    <label for="empresa_cnpj">CNPJ:</label>
    <input type="text" name="empresa_cnpj" id="empresa_cnpj" value="<?php echo $cnpj; ?>" required><br>
    <label for="empresa_nome">Nome da Empresa:</label>
    <input type="text" name="empresa_nome" id="empresa_nome" value="<?php echo $nome; ?>" required><br>
    <label for="empresa_descricao">Descrição da atividade:</label>
    <input type="text" name="empresa_descricao" id="empresa_descricao" value="<?php echo $descricao; ?>" required><br>
    <label for="empresa_endereco">Endereço:</label>
    <input type="text" name="empresa_endereco" id="empresa_endereco" value="<?php echo $endereco; ?>" required><br>
    <input type="submit" name="submit" value="Enviar"><br>
</form>


<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $cadastro_status = alterar_empresa(
            $_SESSION['empresa_id'],
            $_POST["empresa_cnpj"],
            $_POST["empresa_email"], 
            $_POST["empresa_nome"], 
            $_POST["empresa_descricao"],
            $_POST["empresa_senha"],
            $_POST["empresa_endereco"]

        );

        if ($cadastro_status) {
            echo "Alteração realizado com sucesso! Você será redirecionado em instantes. <br><br>";
            echo "<script>
                setTimeout(function() {
                window.location.href = 'empresa_dados.php'},3000);
                </script>";
        }
        else {}
    }
?>





</body>
<script>
function inativar_empresa() {
    if (confirm("Tem certeza que deseja descadastrar sua empresa?") == true) {
        window.location.href = 'empresa_inativar.php';
    }
}
</script>
</html>