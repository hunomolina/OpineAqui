<?php
require_once 'bd_conexao.php';
session_start();
// O código PHP aqui não tem variáveis de sessão críticas, mas a tag final ?> foi adicionada.
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa - OpineAqui</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header role="banner">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Menu principal">
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
                            <a class="nav-link" href="cliente_avaliacao.php">Avalie uma empresa</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="empresa_adicionar.php">Cadastrar Empresa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="empresa_logon.php">Login (Empresa)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container shadow px-2 my-2 bg-body rounded">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande">
                <img src="../images/logo.png" alt="OpineAqui - Logotipo Grande" class="img-fluid">
            </div>
            <hr>
            <div class="col-12 text-center mt-1 mb-3">
                <h1>Cadastrar Empresa</h1>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="col-12 col-md-8">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="empresa_cadastrar" id="empresa_cadastrar">
                        <fieldset>
                            <legend class="visually-hidden">Formulário de Cadastro de Nova Empresa</legend>

                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="empresa_email">E-mail (obrigatório):</label>
                                    <input type="email" class="form-control" name="empresa_email" id="empresa_email" required aria-required="true">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="empresa_senha">Senha (obrigatório):</label>
                                    <input type="password" class="form-control" name="empresa_senha" id="empresa_senha" required aria-required="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="empresa_cnpj">CNPJ (obrigatório):</label>
                                    <input type="text" class="form-control" name="empresa_cnpj" id="empresa_cnpj" required aria-required="true" maxlength="18">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="empresa_nome">Nome da Empresa (obrigatório):</label>
                                    <input type="text" class="form-control" name="empresa_nome" id="empresa_nome" required aria-required="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="empresa_descricao">Descrição da atividade (obrigatório):</label>
                                    <input type="text" class="form-control" name="empresa_descricao" id="empresa_descricao" required aria-required="true">
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="empresa_endereco">Endereço (obrigatório):</label>
                                    <input type="text" class="form-control" name="empresa_endereco" id="empresa_endereco" required aria-required="true">
                                </div>
                            </div>

                            <div class="row pb-1 mb-2 d-flex justify-content-end">
                                <div class="col-3">
                                    <button type="submit" class="btn btn-primary w-100" name="submit" value="Enviar">Cadastrar</button>
                                </div>
                                <div class="col-9" id="mensagem_enviar" role="status" aria-live="polite"></div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer role="contentinfo">
        </footer>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ⚠️ Segurança: Usar htmlspecialchars em todos os dados do POST antes de qualquer uso, inclusive se forem passados para funções
    $cnpj = htmlspecialchars($_POST["empresa_cnpj"] ?? '');
    $email = htmlspecialchars($_POST["empresa_email"] ?? '');
    $nome = htmlspecialchars($_POST["empresa_nome"] ?? '');
    $descricao = htmlspecialchars($_POST["empresa_descricao"] ?? '');
    $senha = $_POST["empresa_senha"] ?? ''; // A senha deve ser tratada com hash antes de salvar, mas não com htmlspecialchars

    $cadastro_status = cadastrar_empresa(
        $cnpj,
        $email,
        $nome,
        $descricao,
        $senha, // A função 'cadastrar_empresa' deve fazer o hash da senha
        htmlspecialchars($_POST["empresa_endereco"] ?? '')
    );

    // ⚠️ Acessibilidade: Usar PHP para redirecionar se for sucesso, evitando setTimeout()
    if ($cadastro_status) {
        // Redirecionamento instantâneo para a próxima página ou página de sucesso.
        header("Location: empresa_dados.php?status=cadastro_sucesso");
        exit();
    }
    // Caso de falha, exibe a mensagem via JS no elemento com role="status"
    // Isso garante que o leitor de tela leia a mensagem
    ?>
    <script>
        document.getElementById('mensagem_enviar').innerHTML = '<span style="color: red; display:block; text-align:center;">CNPJ ou e-mail já existente na base. Por favor, faça o login.</span>';
    </script>
    <?php
}
?>

    <script src="consultar_cnpj.js"></script>
</body>

</html>
