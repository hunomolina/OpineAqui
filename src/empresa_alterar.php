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
            <a href="index.php">
                <img src="../images/logo.png" alt="logo" class="logo">
            </a>
            <div class="container-fluid">        
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="empresa_dados.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="empresa_dados.php">Avaliações da empresa</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="cliente_avaliacao.php">Avalie uma empresa</a>
                    </li> -->
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="empresa_logoff.php">Logoff</a>
                    </li>
                </ul>
                </div>    
            </div>        
        </nav>
    </header>
    
    <div class="container shadow px-2 mb-2 mt-1 bg-body rounded">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande"><img src="../images/logo.png" alt="logo"></div>
            <hr>            
            <div class="col-12 text-center mt-1 mb-3">
                <h2>Alterar dados da empresa</h2>

                <h3>Empresa: <? echo $_SESSION['empresa_nome']; ?></h3>
                
                <?php
                $empresas = dados_empresa($_SESSION['empresa_id']);
                if ($empresas->num_rows > 0) {
                    while ($row = $empresas->fetch_assoc()) {
                        $cnpj = $row["cnpj"];
                        $email = $row["email"];
                        $nome = $row["nome"];
                        $descricao = $row["descricao"];
                        $senha = $row["senha"];
                        $endereco = $row["endereco"];
                    } 
                } else {
                    echo "Cadastro não localizados.<br>";
                }
                ?>

                <div class="container position-relative">
                    <div class="text-start position-absolute bottom-0 start-0 ms-3">
                        <a href="#" onclick="inativar_empresa();">Inativar empresa na plataforma OpineAqui</a><br>
                    </div>
                    <div class="col-12 d-flex justify-content-center mt-3">
                        <div class="col-12 col-md-8">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name='empresa_cadastrar' id='empresa_cadastrar'>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="empresa_email">E-mail:</label>
                                        <input type="text" class="form-control" name="empresa_email" id="empres_email" value="<?php echo $email; ?>" required>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="empresa_senha">Nova Senha:</label>
                                        <input type="password" class="form-control" name="empresa_senha" id="empresa_senha" value="<?php echo $senha; ?>" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="empresa_cnpj">CNPJ:</label>
                                        <input type="text" class="form-control" name="empresa_cnpj" id="empresa_cnpj" value="<?php echo $cnpj; ?>" required>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="empresa_nome">Nome da Empresa:</label>
                                        <input type="text" class="form-control" name="empresa_nome" id="empresa_nome" value="<?php echo $nome; ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="empresa_descricao">Descrição da atividade:</label>
                                        <input type="text" class="form-control" name="empresa_descricao" id="empresa_descricao" value="<?php echo $descricao; ?>" required>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4">
                                        <label for="empresa_endereco">Endereço:</label>
                                        <input type="text" class="form-control" name="empresa_endereco" id="empresa_endereco" value="<?php echo $endereco; ?>" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary" name="submit" value="Enviar">Enviar</button>
                            </form>
                            <div id="mensagem_enviar"></div>
                        </div>
                    </div>                    
                </div>
                
                
            </div>
        </div>
    </div>


<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $cadastro_status = alterar_empresa(
            $_SESSION['empresa_id'],
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
            // echo "Alteração realizado com sucesso! Você será redirecionado em instantes. <br><br>";
            echo "<script>
            mensagem.innerHTML = '<br>Alteração realizado com sucesso! Você será redirecionado em instantes. <br><br>';
                setTimeout(function() {
                window.location.href = 'empresa_dados.php'},3000);
                </script>";
        }
        else {
            echo "<script>
                    mensagem.innerHTML = '<br>Falha na alteração. Tente novamente.</span>';
                </script>";
        }
    }
?>


    <!-- <footer class="footer-fixo">
        <p>&copy; <span id="anoAtual"></span> Projeto Integrador - UNIVESP. Todos os direitos reservados.</p>
    </footer> -->


</body>
<script>
function inativar_empresa() {
    if (confirm("Tem certeza que deseja descadastrar sua empresa?") == true) {
        window.location.href = 'empresa_inativar.php';
    }
}
</script>
</html>