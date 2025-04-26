<?php
require_once 'bd_conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpineAqui</title>
</head>
<body>

<h1>Opine Aqui - Avalie uma empresa</h1>


<h2>Dados do atendimento</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name='empresa_cadastrar' id='empresa_cadastrar'>
    
    <label for="empresa_avaliada">Empresa avaliada:</label>
    <?php

    if (isset($_GET['id'])) {
        $empresa_id = $_GET['id'];
        echo nome_empresa($empresa_id);
        echo "<input type='hidden' name='empresa_avaliada' value='" . $empresa_id . "'>";
    } else {

        $lista_empresas = lista_empresas();
        if ($lista_empresas->num_rows > 0) {
            echo "<select name='empresa_avaliada' id='empresa_avaliada'>";
            echo "<option disabled selected value> - Selecione uma empresa - </option>";
            while ($row = $lista_empresas->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . 
                $row["nome"] . "</option>";
            }
            echo "</select>";
        }
        else {
            throw new Exception("Registros não localizados.");
        }
    
    }
    ?><br>
    
    <label for="data_atendimento">Data do atendimento:</label> 
    <input type="datetime-local" name="data_atendimento" id="data_atendimento" value="<?php echo date('Y-m-d\TH:i'); ?>" required><br>
    
    <label for="nota">Nota:</label>
    <select name="nota" id="nota">
        <option disabled selected value> - Selecione a nota - </option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select><br>
    
    <label for="comentario">Comentário: </label>
    <input type="text" name="comentario" id="comentario" required><br>


    <h2>Dados do cliente (preenchimento opcional)</h2>

    <label for="cliente_email">E-mail:</label>
    <input type="email" name="cliente_email" id="cliente_email"><br>
    <label for="cliente_nome">Nome:</label>
    <input type="tel" name="cliente_nome" id="cliente_nome"><br>
    <label for="cliente_celular">Celular:</label>
    <input type="text" name="cliente_celular" id="cliente_celular"><br>
    <label for="cliente_autorizacao_marketing">Autorização de marketing:</label>
    <input type="checkbox" name="cliente_autorizacao_marketing" id="cliente_autorizacao_marketing" value=true><br><br>

    <input type="submit" name="submit" value="Enviar"><br>
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_email = isset($_POST["cliente_email"]) ? $_POST["cliente_email"] : "";
    $cliente_nome = isset($_POST["cliente_nome"]) ? $_POST["cliente_nome"] : "";
    $cliente_celular = isset($_POST["cliente_celular"]) ? $_POST["cliente_celular"] : "";
    $cliente_autorizacao_marketing = isset($_POST["cliente_autorizacao_marketing"]) ? 1 : 0;
    
    $id_cliente = cadastrar_cliente(
        $cliente_email,
        $cliente_nome,
        $cliente_celular,
        $cliente_autorizacao_marketing
    );
    
    if ($id_cliente) {
        cadastrar_avaliacao(
            $_POST["empresa_avaliada"],
            $_POST["data_atendimento"],
            $_POST["nota"],
            $_POST["comentario"],
            $id_cliente
        );
    }
    else {
        cadastrar_avaliacao(
            $_POST["empresa_avaliada"],
            $_POST["data_atendimento"],
            $_POST["nota"],
            $_POST["comentario"]
        );
    }

    echo    "<script>
                setTimeout(function() {
                window.location.href = 'cliente_obrigado.php'},100);
            </script>";
}

?>



</body>
</html>