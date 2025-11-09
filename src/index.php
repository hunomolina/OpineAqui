<?php
date_default_timezone_set('America/Sao_Paulo');
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
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a href="index.php">
                <img src="../images/logo.png" alt="OpineAqui" class="logo">
                <-- alterei alt="OpineAqui" para alt="logo" -->
            </a>
            <div class="container-fluid">        
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>   
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="empresa_adicionar.php">Cadastrar</a>
                    </li>   -->
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="empresa_logon.php">Login</a>
                    </li>     -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="cliente_avaliacao.php">Avalie uma empresa</a>
                    </li>            
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="empresa_adicionar.php">Cadastrar</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="empresa_logon.php">Login</a>
                    </li>    
                </ul>
                </div>    
            </div>        
        </nav>
    </header>

    <div class="container shadow px-2 mt-2 mb-5 bg-body rounded" style="flex: 1; line-height: 1.6;">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande"><img src="../images/logo.png" alt="logo"></div>
            <hr>
            <div class="text-center mb-3">
                <h1>Opine aqui: um canal de comunicação para pequenos negócios</h1>
                <div class="d-flex justify-content-center">
                    <div class="col-10 col-md-12 text-center mt-3 mb-3">
                        <p><strong>OpineAqui</strong> é uma solução pensada especialmente para micro e pequenas empresas que buscam entender melhor a experiência de seus clientes. Sabemos que manter uma comunicação eficiente com o público é essencial para qualquer negócio, mas transformar essa troca em informações estruturadas e úteis pode ser um grande desafio — especialmente para empreendedores com recursos limitados.</p>
                        <p><strong>OpineAqui</strong> oferece uma ferramenta acessível e prática para captar a opinião dos clientes e analisar dados de satisfação de forma simples e eficaz.</p>
                        <p>Mais do que um canal de comunicação, <strong>OpineAqui</strong> é um aliado estratégico para quem quer crescer com base no que realmente importa: a voz do cliente.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<footer class="footer-fixo">
    <p>&copy; <span id="anoAtual"></span> Projeto Integrador - UNIVESP. Todos os direitos reservados.</p>
</footer>
</html>
