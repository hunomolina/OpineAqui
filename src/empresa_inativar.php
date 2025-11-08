<?php
/**
 * Página de Inativação de Empresa
 * Conforme Lei 13.146/2015 (LBI) e WCAG 2.1
 */

// Incluir conexão com banco de dados
require_once 'bd_conexao.php';

// Configurar fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Iniciar sessão
session_start();

// Verificar autenticação
if (empty($_SESSION["empresa_id"])) {
    // Redirecionar para página inicial com mensagem
    $_SESSION['mensagem_erro'] = 'Acesso não autorizado. Por favor, faça login.';
    header("Location: empresa_logon.php");
    exit();
}

// Processar inativação
$sucesso = false;
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar_inativacao'])) {
    try {
        // Inativar empresa
        $resultado = inativar_empresa($_SESSION['empresa_id']);
        
        if ($resultado) {
            $sucesso = true;
            $mensagem = 'Empresa inativada com sucesso! Obrigado por usar nossa plataforma.';
            
            // Limpar sessão
            $_SESSION = array();
            session_destroy();
            
            // Redirecionar após 5 segundos
            header("refresh:5;url=index.php");
        } else {
            $mensagem = 'Erro ao inativar empresa. Por favor, tente novamente ou entre em contato com o suporte.';
        }
    } catch (Exception $e) {
        $mensagem = 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.';
        error_log("Erro ao inativar empresa: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Meta tags para SEO e acessibilidade -->
    <meta name="description" content="Página de inativação de cadastro de empresa no OpineAqui.">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="Projeto Integrador UNIVESP">
    
    <title><?php echo $sucesso ? 'Empresa Inativada' : 'Inativar Empresa'; ?> - OpineAqui</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="css/index.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../images/favicon.png">
</head>

<body>
    <!-- Link de atalho para conteúdo principal -->
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
                    <ul class="navbar-nav ms-auto">
                        <?php if (!$sucesso): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="empresa_dados.php">
                                <span aria-hidden="true">🏢</span> Meus Dados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="empresa_logoff.php">
                                <span aria-hidden="true">🚪</span> Sair
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>        
        </nav>
    </header>

    <!-- Conteúdo Principal -->
    <main id="conteudo-principal" class="container shadow px-2 my-5 bg-body rounded">
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
            
            <!-- Seção de Inativação -->
            <section class="col-12 text-center my-5" aria-labelledby="titulo-inativacao">
                
                <?php if ($sucesso): ?>
                    <!-- Mensagem de sucesso -->
                    <div class="alert alert-success" 
                         role="status" 
                         aria-live="polite" 
                         aria-atomic="true">
                        <h1 id="titulo-inativacao" class="alert-heading">
                            <span aria-hidden="true">✅</span> 
                            Empresa Inativada com Sucesso!
                        </h1>
                        <hr>
                        <p class="mb-0">
                            <?php echo htmlspecialchars($mensagem); ?>
                        </p>
                        <p class="mt-3">
                            <small>Você será redirecionado para a página inicial em <span id="contador" aria-live="polite">5</span> segundos...</small>
                        </p>
                        <div class="mt-4">
                            <a href="index.php" class="btn btn-primary btn-lg">
                                Ir para a página inicial agora
                            </a>
                        </div>
                    </div>
                    
                <?php elseif ($mensagem): ?>
                    <!-- Mensagem de erro -->
                    <div class="alert alert-danger" 
                         role="alert" 
                         aria-live="assertive" 
                         aria-atomic="true">
                        <h1 id="titulo-inativacao" class="alert-heading">
                            <span aria-hidden="true">⚠️</span> 
                            Erro ao Inativar Empresa
                        </h1>
                        <hr>
                        <p class="mb-0">
                            <?php echo htmlspecialchars($mensagem); ?>
                        </p>
                        <div class="mt-4">
                            <a href="empresa_dados.php" class="btn btn-primary btn-lg me-2">
                                Voltar aos Meus Dados
                            </a>
                            <a href="contato.php" class="btn btn-outline-secondary btn-lg">
                                Entrar em Contato
                            </a>
                        </div>
                    </div>
                    
                <?php else: ?>
                    <!-- Formulário de confirmação -->
                    <div class="alert alert-warning" role="alert">
                        <h1 id="titulo-inativacao" class="alert-heading">
                            <span aria-hidden="true">⚠️</span> 
                            Confirmar Inativação de Empresa
                        </h1>
                        <hr>
                        <p>
                            Você está prestes a <strong>inativar</strong> o cadastro da sua empresa na plataforma OpineAqui.
                        </p>
                        <p class="mb-0">
                            Esta ação <strong>não pode ser desfeita</strong>. Seus dados serão marcados como inativos e você não poderá mais receber avaliações.
                        </p>
                    </div>
                    
                    <div class="mt-4">
                        <form method="post" 
                              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
                              id="form-inativacao"
                              aria-labelledby="titulo-inativacao">
                            
                            <!-- Campo de confirmação -->
                            <div class="form-check d-flex justify-content-center mb-4">
                                <input class="form-check-input me-2" 
                                       type="checkbox" 
                                       id="confirmar" 
                                       name="confirmar" 
                                       required
                                       aria-required="true"
                                       aria-describedby="confirmar-help">
                                <label class="form-check-label" for="confirmar">
                                    Confirmo que desejo inativar minha empresa
                                </label>
                            </div>
                            <div id="confirmar-help" class="form-text text-center mb-4">
                                Marque esta caixa para confirmar que você entende as consequências desta ação.
                            </div>
                            
                            <!-- Botões de ação -->
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <button type="submit" 
                                        class="btn btn-danger btn-lg" 
                                        name="confirmar_inativacao" 
                                        id="btn-confirmar"
                                        disabled
                                        aria-label="Confirmar inativação da empresa">
                                    <span aria-hidden="true">🗑️</span> Confirmar Inativação
                                </button>
                                <a href="empresa_dados.php" 
                                   class="btn btn-secondary btn-lg"
                                   aria-label="Cancelar e voltar aos dados da empresa">
                                    <span aria-hidden="true">↩️</span> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                
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
    
    <!-- Scripts personalizados -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preencher ano atual no footer
            const anoAtual = new Date().getFullYear();
            document.getElementById('anoAtual').textContent = anoAtual;
            
            <?php if ($sucesso): ?>
            // Contador regressivo
            let segundos = 5;
            const contadorElement = document.getElementById('contador');
            
            const interval = setInterval(function() {
                segundos--;
                if (contadorElement) {
                    contadorElement.textContent = segundos;
                }
                
                if (segundos <= 0) {
                    clearInterval(interval);
                    window.location.href = 'index.php';
                }
            }, 1000);
            
            // Dar foco na mensagem de sucesso
            const alertElement = document.querySelector('[role="status"]');
            if (alertElement) {
                alertElement.setAttribute('tabindex', '-1');
                alertElement.focus();
            }
            <?php endif; ?>
            
            <?php if (!$sucesso && !$mensagem): ?>
            // Habilitar botão de confirmação apenas quando checkbox for marcado
            const checkbox = document.getElementById('confirmar');
            const btnConfirmar = document.getElementById('btn-confirmar');
            
            if (checkbox && btnConfirmar) {
                checkbox.addEventListener('change', function() {
                    btnConfirmar.disabled = !this.checked;
                    
                    if (this.checked) {
                        btnConfirmar.setAttribute('aria-disabled', 'false');
                    } else {
                        btnConfirmar.setAttribute('aria-disabled', 'true');
                    }
                });
            }
            
            // Confirmar ação antes de enviar
            const form = document.getElementById('form-inativacao');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Tem certeza que deseja inativar sua empresa? Esta ação não pode ser desfeita.')) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
            <?php endif; ?>
        });
    </script>
</body>
</html>
