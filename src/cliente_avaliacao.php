<?php
require_once 'bd_conexao.php';

// Funções de apoio para dados:
// Assumindo que nome_empresa($id) retorna o nome da empresa
// Assumindo que lista_empresas() retorna o resultado da consulta de empresas
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliar uma Empresa - OpineAqui</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header role="banner">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Menu de navegação principal">
            <a class="navbar-brand" href="index.php">
                <img src="../images/logo.png" alt="OpineAqui - Logotipo" class="logo">
            </a>
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="cliente_avaliacao.php">Avaliar uma Empresa</a>
                        </li>
                    </ul>
                    </div>
            </div>
        </nav>
    </header>

    <main class="container shadow px-2 bg-body rounded mt-2 pb-3" role="main">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande">
                <img src="../images/logo.png" alt="OpineAqui - Logotipo Grande">
            </div>
            <hr>

            <div class="col-12 text-center">
                <h1 class="mb-4">Formulário de Avaliação de Empresa</h1>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name='avaliacao_form' id='avaliacao_form' aria-labelledby="form-title">
                    <h2 class="visually-hidden" id="form-title">Avaliação e Dados do Cliente</h2>

                    <fieldset class="mb-4">
                        <legend class="label-empresa h3 mb-4">Dados da Avaliação (Obrigatório)</legend>

                        <div class="row d-flex justify-content-center gap-5 mb-3">
                            <div class="col-6">
                                <label for="empresa_avaliada" class="label-empresa">Empresa avaliada:</label>

                                <?php
                                $nome_empresa_display = '';
                                $empresa_id = '';

                                if (isset($_GET['id'])) {
                                    $empresa_id = htmlspecialchars($_GET['id']);
                                    $nome_empresa_display = htmlspecialchars(nome_empresa($empresa_id) ?? 'Empresa não encontrada');

                                    // Se o ID vier via GET, exibe o nome e usa input hidden
                                    echo "<span class='form-control-plaintext label-empresa' aria-live='polite'>" . $nome_empresa_display . "</span>";
                                    echo "<input type='hidden' name='empresa_avaliada' value='" . $empresa_id . "'>";
                                } else {
                                    // Se não, exibe o dropdown
                                    $lista_empresas = lista_empresas();
                                    if ($lista_empresas && $lista_empresas->num_rows > 0) {
                                        echo "<select name='empresa_avaliada' id='empresa_avaliada' class='form-select' required aria-required='true'>";
                                        echo "<option disabled selected value> Selecione a empresa </option>";
                                        while ($row = $lista_empresas->fetch_assoc()) {
                                            $nome = htmlspecialchars($row["nome"]);
                                            $id = htmlspecialchars($row["id"]);
                                            echo "<option value='" . $id . "'>" . $nome . "</option>";
                                        }
                                        echo "</select>";
                                    } else {
                                        echo "<p role='alert' style='color: red;'>Nenhuma empresa disponível para avaliação.</p>";
                                        echo "<input type='hidden' name='empresa_avaliada' value=''>";
                                        // throw new Exception("Registros não localizados."); // Evitar exceptions visíveis ao usuário final
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center gap-5">
                            <div class="col-3">
                                <label for="data_atendimento">Data e Hora do Atendimento:</label>
                                <input type="datetime-local" class="form-control" name="data_atendimento" id="data_atendimento" value="<?php echo date('Y-m-d\TH:i'); ?>" required aria-required="true">
                            </div>

                            <div class="col-3">
                                <label for="nota">Nota (1 a 10):</label>
                                <select name="nota" id="nota" class="form-select" required aria-required="true">
                                    <option disabled selected value>Selecione a nota</option>
                                    <?php for ($i = 1; $i <= 10; $i++) {
                                        echo "<option value='{$i}'>{$i}</option>";
                                    } ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="comentario">Comentário (obrigatório): </label>
                                <input type="text" class="form-control" name="comentario" id="comentario" required aria-required="true">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend class="label-empresa h3 mt-5 mb-4">Dados do Cliente (Opcional)</legend>

                        <div class="row d-flex justify-content-center gap-5 mb-2">
                            <div class="col-4">
                                <label for="cliente_nome">Nome:</label>
                                <input type="text" class="form-control" name="cliente_nome" id="cliente_nome" autocomplete="name">
                            </div>
                            <div class="col-3">
                                <label for="cliente_email">E-mail:</label>
                                <input type="email" class="form-control" name="cliente_email" id="cliente_email" autocomplete="email">
                            </div>
                            <div class="col-3">
                                <label for="cliente_celular">Celular:</label>
                                <input type="tel" class="form-control" name="cliente_celular" id="cliente_celular" autocomplete="tel">
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cliente_autorizacao_marketing" id="cliente_autorizacao_marketing" value="1">
                                <label class="form-check-label" for="cliente_autorizacao_marketing">
                                    Autorizo o envio de e-mails com ofertas pela empresa avaliada.
                                </label>
                            </div>
                        </div>
                    </fieldset>


                    <div class="mt-4 mb-2 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-3 px-5" name="submit" value="Enviar">Enviar Avaliação</button>
                    </div>
                    <div id="feedback_avaliacao" role="status" aria-live="polite"></div>
                </form>
            </div>
        </div>
    </main>

    <footer role="contentinfo">
        </footer>


    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // ⚠️ Segurança: Usar htmlspecialchars em todos os dados
        if (!isset($_POST["empresa_avaliada"]) || empty($_POST["empresa_avaliada"])) {
            echo "<script>document.getElementById('feedback_avaliacao').innerHTML = '<p style=\"color: red;\" role=\"alert\">Erro: Empresa avaliada não foi selecionada.</p>';</script>";
            exit();
        }

        $empresa_avaliada = htmlspecialchars($_POST["empresa_avaliada"]);
        $data_atendimento = htmlspecialchars($_POST["data_atendimento"]);
        $nota = htmlspecialchars($_POST["nota"]);
        $comentario = htmlspecialchars($_POST["comentario"]);
        $cliente_email = htmlspecialchars($_POST["cliente_email"] ?? "");
        $cliente_nome = htmlspecialchars($_POST["cliente_nome"] ?? "");
        $cliente_celular = htmlspecialchars($_POST["cliente_celular"] ?? "");
        $cliente_autorizacao_marketing = isset($_POST["cliente_autorizacao_marketing"]) ? 1 : 0;

        // Assumindo que cadastrar_cliente e cadastrar_avaliacao existem e funcionam.

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

        // ⚠️ Acessibilidade: Redirecionamento via header() é o método mais acessível e robusto.
        header('Location: cliente_obrigado.php');
        exit();
    }
    ?>

</body>
</html>
