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
    <-- inserido link de pular para o conteúdo principal-->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" role="navigation">
        <-- inserido role="navigation" na nav-->
            <a href="index.php">
                <img src="../images/logo.png" alt="OpineAqui" class="logo">
           <-- alterado alt="OpineAqui"-->
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

    <div class="container shadow px-2 my-3 bg-body rounded">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande"><img src="../images/logo.png" alt="logo"></div>
            <hr>
            <div class="col-12 text-center mt-1 mb-3">
                <h2>Entre com o Login da Empresa</h2>

                <div class="container d-flex justify-content-center align-items-center py-2">
                    <div class="col-12 col-md-4">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name='empresa_logon' id='empresa_logon'>
                            <div class="mb-3">
                                <label for="empresa_email">E-mail:</label>
                                <input type="text" class="form-control" name="empresa_email" id="empresa_email" required>
                            </div>   
                            <div class="mb-4">
                                <label for="empresa_senha">Senha:</label>
                                <input type="password" class="form-control" name="empresa_senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit" value="Enviar">Enviar</button>
                            <div id="mensagem_enviar"></div>
                        </form>
                    </div>
                </div>    
            </div>
        </div>
    </div>        

<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["empresa_email"]) && isset($_POST["empresa_senha"]) ) {

        $logon_status = logon_empresa($_POST["empresa_email"], $_POST["empresa_senha"]);
        echo "<script>
                var mensagem = document.querySelector('#mensagem_enviar');
              </script>";
        if ($logon_status) {
            echo "<script>
                mensagem.innerHTML = '<br>Login efetuado com sucesso! Você será redirecionado em instantes';
                setTimeout(function() {
                window.location.href = 'empresa_dados.php'},3000);
                </script>";
        }
        else {
            echo "<script>
                mensagem.innerHTML = '<br>Login ou senha incorretos. Tente novamente.';
                </script>";
        }
    }
}
?>

<br><br>
 

</body>

    <!-- <footer class="footer-fixo" role="contentinfo">
        <--inseri role="contentinfo" no footer-->
        <p>&copy; <span id="anoAtual"></span> Projeto Integrador - UNIVESP. Todos os direitos reservados.</p>
    </footer> -->
</html>
