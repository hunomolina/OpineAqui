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
    <!-- Bootstrap e CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>


<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a href="index.html">
                <img src="../images/logo.png" alt="logo" class="logo">
            </a>
            <div class="container-fluid">        
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="empresa_adicionar.php">Cadastrar</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="empresa_logon.php">Logon</a>
                    </li>    
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="cliente_avaliacao.php">Avalie uma empresa</a>
                    </li>            
                </ul> -->
                </div>    
            </div>        
        </nav>
    </header>   

    <div class="container shadow px-2 my-5 bg-body rounded">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande"><img src="../images/logo.png" alt="logo"></div>
            <hr>
            <div class="col-12 text-center my-5">
                <?php 
                inativar_empresa($_SESSION['empresa_id']);
                $_SESSION = array();
                session_destroy(); 
                echo "<h1>Empresa inativada com sucesso!<br> Obrigado por usar nossa plataforma.</h1> <br>";
                echo "<script>
                    setTimeout(function() {
                    window.location.href = 'index.php'},5000);
                    </script>";    
                ?>
            </div>
        </div>
    </div>

    <footer class="footer-fixo">
        <p>&copy; <span id="anoAtual"></span> Projeto Integrador - UNIVESP. Todos os direitos reservados.</p>
    </footer>
    
</body>
</html>