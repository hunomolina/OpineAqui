<?php
require_once 'bd_conexao.php';
session_start();

// --- 1. Verificação de Sessão Acessível ---
if (empty($_SESSION["empresa_id"])) {
    // Redirecionamento mais robusto e acessível (sem JavaScript)
    header("Location: index.php?erro=recurso_nao_permitido");
    exit();
}

$empresa_nome = htmlspecialchars($_SESSION['empresa_nome'] ?? 'Empresa');
$empresa_id = $_SESSION['empresa_id'];

// --- 2. Busca de Dados (Mantido, mas com precaução) ---
$cnpj = $email = $nome = $descricao = $senha = $endereco = '';
$empresas = dados_empresa($empresa_id); // Assumindo que esta função existe
if ($empresas && $empresas->num_rows > 0) {
    $row = $empresas->fetch_assoc();
    // ⚠️ Acessibilidade/Segurança: Limpar e usar htmlspecialchars nos dados recuperados
    $cnpj = htmlspecialchars($row["cnpj"] ?? '');
    $email = htmlspecialchars($row["email"] ?? '');
    $nome = htmlspecialchars($row["nome"] ?? '');
    $descricao = htmlspecialchars($row["descricao"] ?? '');
    // A senha nunca deve ser retornada ou preenchida em um campo de input 'password'
    // Se você precisa que o usuário insira uma senha, o campo deve vir VAZIO.
    // Manter o campo vazio força o usuário a definir uma nova senha, ou o script deve ignorar o campo se vazio.
    $senha_placeholder = "Deixe vazio para não alterar"; // Sugestão para acessibilidade
    $endereco = htmlspecialchars($row["endereco"] ?? '');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados Cadastrais - <?php echo $empresa_nome; ?> - OpineAqui</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <header role="banner">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Menu principal da empresa">
            <a class="navbar-brand" href="empresa_dados.php">
                <img src="../images/logo.png" alt="OpineAqui - Logotipo" class="logo">
            </a>
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="empresa_dados.php">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="empresa_alterar.php">Alterar Dados</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="empresa_logoff.php">Sair (Logoff)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container shadow px-2 mb-2 mt-1 bg-body rounded">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande">
                <img src="../images/logo.png" alt="OpineAqui - Logotipo Grande">
            </div>
            <hr>
            <div class="col-12 text-center mt-1 mb-3">
                <h1>Alterar Dados Cadastrais da Empresa</h1>

                <h2>Empresa: <?php echo $empresa_nome; ?></h2>

                <div class="container position-relative">
                    <div class="text-start position-absolute bottom-0 start-0 ms-3">
                        <a href="#" onclick="inativar_empresa();" aria-label="Inativar ou excluir empresa na plataforma OpineAqui">Inativar empresa na plataforma OpineAqui</a><br>
                    </div>

                    <div class="col-12 d-flex justify-content-center mt-3">
                        <div class="col-12 col-md-8">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name='empresa_alterar_form' id='empresa_alterar_form'>
                                <fieldset>
                                    <legend class="visually-hidden">Formulário de alteração de dados</legend>

                                    <div class="row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="empresa_email">E-mail (obrigatório):</label>
                                            <input type="email" class="form-control" name="empresa_email" id="empresa_email" value="<?php echo $email; ?>" required aria-required="true">
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="empresa_senha">Nova Senha:</label>
                                            <input type="password" class="form-control" name="empresa_senha" id="empresa_senha" placeholder="<?php echo $senha_placeholder; ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="empresa_cnpj">CNPJ (obrigatório):</label>
                                            <input type="text" class="form-control" name="empresa_cnpj" id="empresa_cnpj" value="<?php echo $cnpj; ?>" required aria-required="true">
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="empresa_nome">Nome da Empresa (obrigatório):</label>
                                            <input type="text" class="form-control" name="empresa_nome" id="empresa_nome" value="<?php echo $nome; ?>" required aria-required="true">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="empresa_descricao">Descrição da atividade (obrigatório):</label>
                                            <input type="text" class="form-control" name="empresa_descricao" id="empresa_descricao" value="<?php echo $descricao; ?>" required aria-required="true">
                                        </div>
                                        <div class="col-12 col-md-6 mb-4">
                                            <label for="empresa_endereco">Endereço (obrigatório):</label>
                                            <input type="text" class="form-control" name="empresa_endereco" id="empresa_endereco" value="<?php echo $endereco; ?>" required aria-required="true">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="submit" value="Enviar">Salvar Alterações</button>
                                </fieldset>
                            </form>
                            <div id="mensagem_enviar" role="status" aria-live="polite"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Trate a senha: se o campo estiver vazio, não altere no banco.
    $nova_senha = !empty($_POST["empresa_senha"]) ? $_POST["empresa_senha"] : null; // Use null se vazio.

    $cadastro_status = alterar_empresa(
        $empresa_id,
        $_POST["empresa_cnpj"],
        $_POST["empresa_email"],
        $_POST["empresa_nome"],
        $_POST["empresa_descricao"],
        $nova_senha, // Usar a senha tratada
        $_POST["empresa_endereco"]
    );

    // ⚠️ Acessibilidade: Evitar JS para exibir mensagem e redirecionar.
    // Para simplificar e manter a acessibilidade, faremos o output PHP direto
    // e o redirecionamento com header() após o processamento.
    if ($cadastro_status) {
        // Redirecionamento com header() é o mais acessível e robusto.
        // Adicione um parâmetro de sucesso na URL para exibir a mensagem na próxima página.
        header("Location: empresa_dados.php?status=alteracao_sucesso");
        exit();
    } else {
        // Se a alteração falhar, exibir a mensagem diretamente no elemento 'role="status"'
        echo "<script>
              document.getElementById('mensagem_enviar').innerHTML = '<br><span style=\"color: red;\">Falha na alteração. Tente novamente.</span>';
              </script>";
    }
}
?>

    <footer role="contentinfo">
        </footer>

</body>
<script>
// ⚠️ Acessibilidade: A função de inativação está OK, mas o texto do prompt deve ser claro.
function inativar_empresa() {
    if (confirm("ATENÇÃO: Você confirma o descadastro de sua empresa? Isso a tornará inativa na plataforma OpineAqui.") == true) {
        window.location.href = 'empresa_inativar.php';
    }
}
</script>
</html>
