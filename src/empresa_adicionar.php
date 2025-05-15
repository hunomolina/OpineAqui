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
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a href="index.php">
                <img src="../images/logo.png" alt="logo" class="logo">
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

    <div class="container shadow px-2 my-2 bg-body rounded">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande">
                <img src="../images/logo.png" alt="logo" class="img-fluid">
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
                            <div class="col-12 col-md-6 mb-3">
                                <label for="empresa_nome">Nome da Empresa:</label>
                                <input type="text" class="form-control" name="empresa_nome" id="empresa_nome" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="empresa_descricao">Descrição da atividade:</label>
                                <input type="text" class="form-control" name="empresa_descricao" id="empresa_descricao" required>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="empresa_endereco">Endereço:</label>
                                <input type="text" class="form-control" name="empresa_endereco" id="empresa_endereco" required>
                            </div>
                        </div>
                        <div class="row pb-1 mb-2 d-flex justify-content-end">
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary w-100" name="submit" value="Enviar">Enviar</button>
                            </div>
                            <div id="mensagem_enviar"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <footer class="footer-fixo">
            <p>&copy; <span id="anoAtual"></span> Projeto Integrador - UNIVESP. Todos os direitos reservados.</p>
    </footer> -->


<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $cadastro_status = cadastrar_empresa(
            $_POST["empresa_cnpj"],
            $_POST["empresa_email"], 
            $_POST["empresa_nome"], 
            $_POST["empresa_descricao"],
            $_POST["empresa_senha"],
            $_POST["empresa_endereco"]
        );


        echo "<script>
                var mensagem = document.querySelector('#mensagem_enviar');
              </script>";


        if ($cadastro_status) {
            // echo "Cadastro realizado com sucesso! Você será redirecionado em instantes. <br><br>";
            echo "<script>
                mensagem.innerHTML = '<br>Cadastro realizado com sucesso! Você será redirecionado em instantes.';
                setTimeout(function() {
                window.location.href = 'empresa_dados.php'},3000);
                </script>";
        }
        else {
            echo "<script>
                    mensagem.innerHTML = '<br><span style=\"display:block\; text-align:center\;\">CNPJ ou e-mail já existente na base. Faça o login.</span>';
                </script>";
        }
    }
?>

</body>
</html>