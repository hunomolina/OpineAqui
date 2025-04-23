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

<h1>Opine Aqui - Dados da empresa</h1>

<h2>Empresa: <? echo $_SESSION['empresa_nome']; ?></h2>

<a href="empresa_alterar.php">Alterar dados cadastrais</a><br>
<a href="empresa_logoff.php">Logoff</a><br>

<br><br>

<?php
$avaliacoes = select_avaliacoes($_SESSION['empresa_id']);
if ($avaliacoes->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; border: 1px solid black;'>";
    echo "<tr><th colspan='7'><h2>Lista avaliações da empresa logada</h2></th></tr>";
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
        echo "<td>" . ($row["autorizacao_marketing"] ? 'Sim' : '') . "</td>";
        echo "</tr>";
    }
    echo "</tr>";
} else {
    echo "Você ainda não possui avaliações. <br>";
}
?>


</body>
</html>