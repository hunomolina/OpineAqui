<?php
require_once 'bd_conexao.php';
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>Opine Aqui - Testes</h1>



<?
echo "<h2>Logon Empresa</h2>";

logon_empresa(11111111000111, "123456");
echo ("id_empresa:" .  $_SESSION['empresa_id'] . "<br>");
echo ("nome_empresa:" .  $_SESSION['empresa_nome'] . "<br>");
echo ("cnpj_empresa:" .  $_SESSION['empresa_cnpj'] . "<br>");
?>

<br><br>




<?php
cadastrar_empresa(
    11111111000111,
    'contato@empresatres.com.br', 
    'Empresa Três', 
    'Atividade hoteleira',
    '123456',
    'Rua Três, n. 3, Bairro Três, São Paulo/SP, CEP 33333-333',
    'Hotelaria'
);
?>
<br><br>"
     


<?php
alterar_empresa(1, 11111111000111, 'contato@empresatres.com.br', 
'Empresa Três', 
'Atividade hoteleira',
'123456',
'Rua Três, n. 3, Bairro Três, São Paulo/SP, CEP 33333-333',
'Hotelaria')
?>


<?
$id_cliente = cadastrar_cliente("", 'Ticio de Teste', '11-1141234', 1);
if ($id_cliente) {
    cadastrar_avaliacao(1, "2025-03-12 11:00:00", 7, "Legal!", $id_cliente);
} else {
    cadastrar_avaliacao(1, "2025-03-12 11:00:00", 7, "Legal!", "NULL");
}

?>

<?php
$empresas = dados_empresa();
if ($empresas->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; border: 1px solid black;'>";
    echo "<tr><th colspan='6'><h2>Exibe dados da empresa indicada pelo id</h2></th></tr>";
    echo "<tr>
            <th>CNPJ</th>
            <th>E-mail</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Endereço</th>
            <th>Atividade</th>
        </tr>";
    while ($row = $empresas->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["cnpj"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["nome"] . "</td>";
        echo "<td>" . $row["descricao"] . "</td>";
        echo "<td>" . $row["endereco"] . "</td>";
        echo "<td>" . $row["atividade"] . "</td>";
        echo "</tr>";
    }
    echo "</tr>";
} else {
    echo "Registros não localizados.";
}
?>

<br /><br />


<?php
$avaliacoes = select_avaliacoes(1);
if ($avaliacoes->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; border: 1px solid black;'>";
    echo "<tr><th colspan='7'><h2>Lista avaliações da empresa indicada pelo id</h2></th></tr>";
    echo "<tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Data do Atendimento</th>
            <th>Nota</th>
            <th>Comentário</th>
            <th>Autorização Marketing</th>
        </tr>";
    while ($row = $avaliacoes->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["nome"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["celular"] . "</td>";
        echo "<td>" . $row["data_atendimento"] . "</td>";
        echo "<td>" . $row["nota"] . "</td>";
        echo "<td>" . $row["comentario"] . "</td>";
        echo "<td>" . $row["autorizacao_marketing"] . "</td>";
        echo "</tr>";
    }
    echo "</tr>";
} else {
    echo "Registros não localizados.";
}
?>




<?php
echo "<h2>Relação de empresas para dropdown</h2>";
$lista_empresas = lista_empresas();
if ($lista_empresas->num_rows > 0) {
    echo "<label for='empresas'>Escolha uma empresa:</label>";
    echo "<select name='lista_empresas' id='lista_empresas'>";
    while ($row = $lista_empresas->fetch_assoc()) {
        echo "<option value='" . $row["id"] . "'>" . 
        $row["nome"] . "</option>";
    }
    echo "</select>";
}
else {
    echo "Registros não localizados.";
}

echo "<br><br><br>";

?>


</body>
</html>