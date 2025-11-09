<?php
require_once 'bd_conexao.php';
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
    <a href="#main-content" class="skip-link">Pular para o conteúdo principal</a>
    <--inseri <a para compliance com lei de acessibilidade -->
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a href="index.php">
                <img src="../images/logo.png" alt="OpineAqui" class="logo">
            </a>
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                    <!-- <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="empresa_alterar.php">Alterar dados cadastrais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="cliente_avaliacao.php">Avalie uma empresa</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="empresa_logoff.php">Logoff</a>
                        </li>
                    </ul> -->
                </div>
            </div>
        </nav>
    </header>

    <div class="container shadow px-2 bg-body rounded mt-2 pb-3">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande"><img src="../images/logo.png" alt="logo"></div>
            <hr> 

            <div class="col-12 text-center">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name='empresa_cadastrar' id='empresa_cadastrar'>
                    
                    <label for="empresa_avaliada" class="label-empresa">Empresa avaliada:</label>

                    <div class="row d-flex justify-content-center gap-5 mb-3">
                        <div class="col-6">
                            <?php
                            if (isset($_GET['id'])) {
                                $empresa_id = $_GET['id'];
                                echo "<span class='label-empresa'>" . nome_empresa($empresa_id) . "</span>";
                                echo "<input type='hidden' name='empresa_avaliada' value='" . $empresa_id . "'>";
                            } else {
                                $lista_empresas = lista_empresas();
                                if ($lista_empresas->num_rows > 0) {
                                    echo "<select name='empresa_avaliada' id='empresa_avaliada' class='form-select' required>";
                                    echo "<option disabled selected value> Selecione a empresa </option>";
                                    while ($row = $lista_empresas->fetch_assoc()) {
                                        echo "<option value='" . $row["id"] . "'>" . $row["nome"] . "</option>";
                                    }
                                    echo "</select>";
                                } else {
                                    echo "<input type='hidden' name='empresa_avaliada' value=''>";
                                    throw new Exception("Registros não localizados.");
                                }
                            }
                            ?>
                        </div>
                    </div>
                    
                    <div class="row d-flex justify-content-center gap-5">
                        <div class="col-3">
                            <label for="data_atendimento">Data do atendimento:</label>
                            <input type="datetime-local" class="form-control" name="data_atendimento" id="data_atendimento" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                        </div>
                        
                        <div class="col-3">
                            <label for="nota">Nota:</label>
                            <select name="nota" id="nota" class="form-select" required>
                                <option disabled selected value>Selecione a nota</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        
                        <div class="col-4">
                            <label for="comentario">Comentário: </label>
                            <input type="text" class="form-control" name="comentario" id="comentario" required>
                        </div>
                    </div>

                    <h2 class="label-empresa mt-5">Dados do cliente (preenchimento opcional)</h2>

                    <div class="row d-flex justify-content-center gap-5 mb-2">
                        <div class="col-4">
                            <label for="cliente_nome">Nome:</label>
                            <input type="tel" class="form-control" name="cliente_nome" id="cliente_nome">
                        </div>
                        <div class="col-3">
                            <label for="cliente_email">E-mail:</label>
                            <input type="email" class="form-control" name="cliente_email" id="cliente_email">
                        </div>
                        <div class="col-3">
                            <label for="cliente_celular">Celular:</label>
                            <input type="text" class="form-control" name="cliente_celular" id="cliente_celular">
                        </div>
                    </div>

                    <div class="me-5 pe-3  float-end">
                        <br>
                        <input type="checkbox" name="cliente_autorizacao_marketing" id="cliente_autorizacao_marketing" value=true>
                        <label for="cliente_autorizacao_marketing">Autorizo o envio de e-mails com ofertas pela empresa avaliada</label>
                    </div>

                    <div class="mt-4 mb-2" style="padding-left: 200px;">
                        <button type="submit" class="btn btn-primary ms-5 mt-3 px-5" name="submit" value="Enviar">Enviar</button>
                    </div>
                </form>


                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (!isset($_POST["empresa_avaliada"]) || empty($_POST["empresa_avaliada"])) {
                        die("Erro: Empresa avaliada não foi selecionada.");
                    }

                    $empresa_avaliada = $_POST["empresa_avaliada"];
                    $data_atendimento = $_POST["data_atendimento"];
                    $nota = $_POST["nota"];
                    $comentario = $_POST["comentario"];
                    $cliente_email = isset($_POST["cliente_email"]) ? $_POST["cliente_email"] : "";
                    $cliente_nome = isset($_POST["cliente_nome"]) ? $_POST["cliente_nome"] : "";
                    $cliente_celular = isset($_POST["cliente_celular"]) ? $_POST["cliente_celular"] : "";
                    $cliente_autorizacao_marketing = isset($_POST["cliente_autorizacao_marketing"]) ? 1 : 0;

                    $id_cliente = cadastrar_cliente(
                        $cliente_email,
                        $cliente_nome,
                        $cliente_celular,
                        $cliente_autorizacao_marketing
                    );

                    if ($id_cliente) {
                        cadastrar_avaliacao(
                            $empresa_avaliada,
                            $data_atendimento,
                            $nota,
                            $comentario,
                            $id_cliente
                        );
                    } else {
                        cadastrar_avaliacao(
                            $empresa_avaliada,
                            $data_atendimento,
                            $nota,
                            $comentario
                        );
                    }

                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'cliente_obrigado.php';
                            }, 100);
                        </script>";
                }

                ?>
            </div>
        </div>
    </div>
    
    <!-- <footer class="footer-fixo" role="contentinfo">
        <-- inseri role="contentinfo" para ajudar na acessibilidade -->
        <p>&copy; <span id="anoAtual"></span> Projeto Integrador - UNIVESP. Todos os direitos reservados.</p>
    </footer> -->

</body>
</html>
