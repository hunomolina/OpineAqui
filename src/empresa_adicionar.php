<?php
require_once 'bd_conexao.php';
session_start();
// Adicionado para o PHP do rodapé
date_default_timezone_set('America/Sao_Paulo'); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Empresa - OpineAqui</title>
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
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>   
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

    <div class="container shadow px-2 my-2 bg-body rounded" id="main-content" role="main">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande">
                <img src="../images/logo.png" alt="Logo OpineAqui" class="img-fluid">
            </div>
            <hr>
            <div class="col-12 text-center mt-1 mb-3">
                <h2>Cadastrar Empresa</h2>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="col-12 col-md-8">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="empresa_cadastrar" id="empresa_cadastrar">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="empresa_email">E-mail:</label>
                                <input type="email" class="form-control" name="empresa_email" id="empresa_email" required>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="empresa_senha">Senha:</label>
                                <input type="password" class="form-control" name="empresa_senha" id="empresa_senha" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="empresa_cnpj">CNPJ:</label>
                                <input type="text" class="form-control" name="empresa_cnpj" id="empresa_cnpj" required>
                            </div>
                            <div class="col-12 col-md-6