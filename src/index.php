<?php
date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OpineAqui - Plataforma acessível de avaliação e feedback para micro e pequenas empresas. Entenda melhor a experiência dos seus clientes.">
    <meta name="keywords" content="avaliação, feedback, pequenas empresas, satisfação do cliente">
    <meta name="author" content="Projeto Integrador UNIVESP">
    
    <title>OpineAqui - Canal de Comunicação para Pequenos Negócios</title>
    
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
                <a href="index.php" class="navbar-brand" aria-label="OpineAqui - Página inicial">
                    <img src="../images/logo.png" 
                         alt="OpineAqui - Plataforma de avaliação para pequenas empresas" 
                         class="logo" 
                         width="150" 
                         height="50"
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
                            <a class="nav-link active" 
                               href="index.php" 
                               aria-current="page">
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
                            <a class="nav-link" href="empresa_logon.php">
                                <span aria-hidden="true">🔑</span> Login
                            </a>
                        </li>    
                    </ul>
                </div>    
            </div>        
        </nav>
    </header>

    <!-- Conteúdo Principal -->
    <main id="conteudo-principal" class="container shadow px-2 mt-4 mb-5 bg-body rounded" style="flex: 1; line-height: 1.6;">
        <div class="row">
            
            <!-- Logo grande (decorativa) -->
            <div class="d-flex justify-content-center my-4" aria-hidden="true">
                <img src="../images/logo.png" 
                     alt="" 
                     class="logo-grande" 
                     role="presentation"
                     loading="lazy">
            </div>
            
            <hr role="separator" aria-label="Separador de conteúdo">
            
            <!-- Seção de apresentação -->
            <section class="text-center mb-4" aria-labelledby="titulo-principal">
                <h1 id="titulo-principal" class="mb-4">
                    Opine aqui: um canal de comunicação para pequenos negócios
                </h1>
                
                <div class="d-flex justify-content-center">
                    <article class="col-12 col-md-10 col-lg-8 text-center mt-3 mb-3">
                        
                        <h2 class="visually-hidden">Sobre o OpineAqui</h2>
                        
                        <p>
                            <strong>OpineAqui</strong> é uma solução pensada especialmente para micro e pequenas empresas que buscam entender melhor a experiência de seus clientes. Sabemos que manter uma comunicação eficiente com o público é essencial para qualquer negócio, mas transformar essa troca em informações estruturadas e úteis pode ser um grande desafio — especialmente para empreendedores com recursos limitados.
                        </p>
                        
                        <p>
                            <strong>OpineAqui</strong> oferece uma ferramenta acessível e prática para captar a opinião dos clientes e analisar dados de satisfação de forma simples e eficaz.
                        </p>
                        
                        <p>
                            Mais do que um canal de comunicação, <strong>OpineAqui</strong> é um aliado estratégico para quem quer crescer com base no que realmente importa: a voz do cliente.
                        </p>
                        
                        <!-- Call to Action -->
                        <div class="mt-4">
                            <a href="cliente_avaliacao.php" 
                               class="btn btn-primary btn-lg me-2 mb-2" 
                               role="button"
                               aria-label="Avaliar uma empresa agora">
                                Avalie uma empresa agora
                            </a>
                            <a href="empresa_adicionar.php" 
                               class="btn btn-outline-primary btn-lg mb-2" 
                               role="button"
                               aria-label="Cadastrar minha empresa">
                                Cadastrar minha empresa
                            </a>
                        </div>
                        
                    </article>
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
            const anoAtual = new Date().getFullYear();
            document.getElementById('anoAtual').textContent = anoAtual;
        });
    </script>
    
    <!-- Script de acessibilidade adicional (opcional) -->
    <script src="js/acessibilidade.js" defer></script>

</body>
</html>
