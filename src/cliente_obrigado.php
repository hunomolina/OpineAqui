<?php
date_default_timezone_set('America/Sao_Paulo'); 
// ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obrigado pela Avaliação - OpineAqui</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">

    <style>
        .skip-link {
            position: absolute;
            left: -9999px;
            top: auto;
            width: 1px;
            height: 1px;
            overflow: hidden;
            z-index: -999;
        }
        .skip-link:focus, .skip-link:active {
            color: #fff;
            background-color: #000;
            left: auto;
            top: auto;
            width: auto;
            height: auto;
            overflow: auto;
            padding: 10px;
            z-index: 999;
            text-decoration: none;
        }
    </style>
    </head>
<body>

    <a href="#main-content" class="skip-link">Pular para o conteúdo principal</a>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" role="navigation">
        <a href="index.php">
                <img src="../images/logo.png" alt="OpineAqui - Página Inicial" class="logo">
                </a>
            <div class="container-fluid">        
            <div class="collapse navbar-collapse" id="navbarNav">
                </div>    
            </div>        
        </nav>
    </header>

    <div class="container shadow px-2 my-5 bg-body rounded" id="main-content" role="main">
    <div class="row">
            <div class="d-flex justify-content-center logo-grande">
                <img src="../images/logo.png" alt="Logo OpineAqui">
                </div>
            <hr>
            <div class="col-12 text-center my-5" role="status">
            <h2>Obrigado por participar da avaliação!</h2>
                <h4 class="mt-5">Sua opinião é muito importante.</h4>
            </div>
        </div>
    </div>

    <footer class="footer-fixo" role="contentinfo">
    <p>&copy; <?php echo date('Y'); ?> Projeto Integrador - UNIVESP. Todos os direitos reservados.</p>
        </footer>
    </body>
</html>
