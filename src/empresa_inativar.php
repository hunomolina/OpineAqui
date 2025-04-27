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
    <h1>Opine Aqui</h1>
    <?php 
    inativar_empresa($_SESSION['empresa_id']);
    $_SESSION = array();
    session_destroy(); 
    echo "Empresa inativada com sucesso! Obrigado por usar nossa plataforma. <br><br>";
    echo "<script>
        setTimeout(function() {
        window.location.href = 'index.php'},5000);
        </script>";    
    ?>
    
</body>
</html>