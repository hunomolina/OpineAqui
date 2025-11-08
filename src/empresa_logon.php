<?php
// Iniciar sessão e configurações
session_start();
date_default_timezone_set('America/Sao_Paulo');

// Incluir função de logon (assumindo que está em outro arquivo)
// require_once 'functions.php';

// Processar o formulário ANTES de qualquer HTML
$mensagem = '';
$tipo_mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["empresa_email"]) && isset($_POST["empresa_senha"])) {
        
        // Sanitizar entrada
        $email = filter_var($_POST["empresa_email"], FILTER_SANITIZE_EMAIL);
        $senha = $_POST["empresa_senha"];
        
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mensagem = 'E-mail inválido. Por favor, insira um e-mail válido.';
            $tipo_mensagem = 'erro';
        } else {
            // Tentar fazer login (substitua pela sua função real)
            $logon_status = logon_empresa($email, $senha);
            
            if ($logon_status) {
                $mensagem = 'Login efetuado com sucesso! Você será redirecionado em instantes...';
                $tipo_mensagem = 'sucesso';
                
                // Redirecionar após 3 segundos
                header("refresh:3;url=empresa_dados.php");
            } else {
                $mensagem = 'Login ou senha incorretos. Por favor, tente novamente.';
                $tipo_mensagem = 'erro';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Meta tags para SEO e acessibilidade -->
    <meta name="description" content="Página de login para empresas cadastradas no OpineAqui - Plataforma de avaliação e feedback.">
    <meta name="author" content="Projeto Integrador UNIVESP">
    
    <title>Login da Empresa - OpineAqui</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="css/index.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../images/favicon.png">
</head>

<body>
    <!-- Link de atalho para conteúdo principal (Skip Navigation) -->
    <a href="#conteudo-principal" class="visually-hidden-focusable skip-link">
        Pular para o conteúdo principal
    </a>

    <!-- Cabeçalho do Site -->
    <header role="banner">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" role="navigation" aria-label="Menu de navegação principal">
            <div class="container-fluid">
                
                <!-- Logo -->
                <a href="index.php" class="navbar-brand" aria-label="OpineAqui - Ir para página inicial">
                    <img src="../images/logo.png" 
                         alt="OpineAqui - Plataforma de avaliação para pequenas empresas" 
                         class="logo" 
                         width="60" 
                         height="60"
                         loading="lazy">
                </a>
                
                <!-- Botão de alternância para dispositivos móveis -->
                <button class="navbar-toggler" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#navbarNav" 
                        aria-controls="navbarNav" 
                        aria-expanded="false" 
                        aria-label="Alternar menu de navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Menu de navegação -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <span aria-hidden="true">🏠</span> Home
                            </a>
                        </li>   
                        <li class="nav-item">
                            <a class="nav-link" href="cliente_avaliacao.php">
                                <span aria-hidden="true">⭐</span> Avalie uma empresa
                            </a>
                        </li>            
                    </ul>
                    
                    <!-- Menu lateral direito -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="empresa_adicionar.php">
                                <span aria-hidden="true">➕</span> Cadastrar
                            </a>
                        </li>  
                        <li class="nav-item">
                            <a class="nav-link active" 
                               href="empresa_logon.php" 
                               aria-current="page">
                                <span aria-hidden="true">🔑</span> Login
                            </a>
                        </li>    
                    </ul>
                </div>
            </div>        
        </nav>
    </header>

    <!-- Conteúdo Principal -->
    <main id="conteudo-principal" class="container shadow px-2 my-3 bg-body rounded">
        <div class="row">
            
            <!-- Logo grande (decorativa) -->
            <div class="d-flex justify-content-center my-4" aria-hidden="true">
                <img src="../images/logo.png" 
                     alt="" 
                     class="logo-grande" 
                     role="presentation"
                     width="100"
                     height="100"
                     loading="lazy">
            </div>
            
            <hr role="separator" aria-label="Separador de conteúdo">
            
            <!-- Seção de Login -->
            <section class="col-12 text-center mt-1 mb-3" aria-labelledby="titulo-login">
                <h1 id="titulo-login" class="mb-4">Login da Empresa</h1>

                <div class="container d-flex justify-content-center align-items-center py-2">
                    <div class="col-12 col-md-6 col-lg-4">
                        
                        <!-- Mensagem de feedback (sucesso ou erro) -->
                        <?php if ($mensagem): ?>
                            <div class="alert alert-<?php echo $tipo_mensagem === 'sucesso' ? 'success' : 'danger'; ?> alert-dismissible fade show" 
                                 role="alert" 
                                 aria-live="polite" 
                                 aria-atomic="true">
                                <strong><?php echo $tipo_mensagem === 'sucesso' ? 'Sucesso!' : 'Erro!'; ?></strong> 
                                <?php echo htmlspecialchars($mensagem); ?>
                                <button type="button" 
                                        class="btn-close" 
                                        data-bs-dismiss="alert" 
                                        aria-label="Fechar mensagem">
                                </button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Formulário de Login -->
                        <form method="post" 
                              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
                              name="empresa_logon" 
                              id="empresa_logon" 
                              novalidate
                              aria-labelledby="titulo-login">
                            
                            <!-- Campo de E-mail -->
                            <div class="mb-3 text-start">
                                <label for="empresa_email" class="form-label">
                                    E-mail: <span class="text-danger" aria-label="obrigatório">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control" 
                                       name="empresa_email" 
                                       id="empresa_email" 
                                       required 
                                       autocomplete="email"
                                       aria-required="true"
                                       aria-describedby="email-help"
                                       placeholder="exemplo@empresa.com.br"
                                       value="<?php echo isset($_POST['empresa_email']) ? htmlspecialchars($_POST['empresa_email']) : ''; ?>">
                                <div id="email-help" class="form-text">
                                    Insira o e-mail cadastrado da sua empresa.
                                </div>
                                <div class="invalid-feedback" role="alert">
                                    Por favor, insira um e-mail válido.
                                </div>
                            </div>   
                            
                            <!-- Campo de Senha -->
                            <div class="mb-4 text-start">
                                <label for="empresa_senha" class="form-label">
                                    Senha: <span class="text-danger" aria-label="obrigatório">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       name="empresa_senha" 
                                       id="empresa_senha" 
                                       required 
                                       autocomplete="current-password"
                                       aria-required="true"
                                       aria-describedby="senha-help"
                                       placeholder="Digite sua senha">
                                <div id="senha-help" class="form-text">
                                    Sua senha é confidencial. Nunca a compartilhe.
                                </div>
                                <div class="invalid-feedback" role="alert">
                                    Por favor, insira sua senha.
                                </div>
                            </div>
                            
                            <!-- Botão de Envio -->
                            <button type="submit" 
                                    class="btn btn-primary btn-lg w-100" 
                                    name="submit" 
                                    value="Enviar"
                                    aria-label="Enviar formulário de login">
                                Entrar
                            </button>
                            
                            <!-- Links adicionais -->
                            <div class="mt-3">
                                <a href="recuperar_senha.php" class="d-block mb-2">
                                    Esqueci minha senha
                                </a>
                                <p class="text-muted">
                                    Não tem cadastro? 
                                    <a href="empresa_adicionar.php">Cadastre sua empresa</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>    
            </section>
        </div>
    </main>

    <!-- Rodapé -->
    <footer class="footer-fixo bg-dark text-white py-3 mt-5" role="contentinfo">
        <div class="container text-center">
            <p class="mb-1">
                &copy; <span id="anoAtual" aria-label="Ano atual"></span> Projeto Integrador - UNIVESP. Todos os direitos reservados.
            </p>
            <p class="mb-0">
                <a href="acessibilidade.php" class="text-white text-decoration-underline">
                    Declaração de Acessibilidade
                </a> | 
                <a href="politica-privacidade.php" class="text-white text-decoration-underline">
                    Política de Privacidade
                </a>
            </p>
        </div>
    </footer>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Script para preencher o ano automaticamente -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preencher ano atual no footer
            const anoAtual = new Date().getFullYear();
            document.getElementById('anoAtual').textContent = anoAtual;
            
            // Validação de formulário HTML5
            const form = document.getElementById('empresa_logon');
            
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
            
            // Anunciar mensagens para leitores de tela
            const alerts = document.querySelectorAll('[role="alert"]');
            if (alerts.length > 0) {
                // Dar foco na primeira mensagem de alerta
                alerts[0].setAttribute('tabindex', '-1');
                alerts[0].focus();
            }
        });
    </script>
</body>
</html>
