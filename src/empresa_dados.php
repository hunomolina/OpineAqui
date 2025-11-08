<?php
require_once 'bd_conexao.php';
session_start();

// Verifica a autenticação do usuário
if (empty($_SESSION["empresa_id"])) {
    // ⚠️ Acessibilidade: Mensagem e redirecionamento de forma mais clara para leitores de tela.
    header("Location: index.php?erro=recurso_nao_permitido");
    exit();
}
// Define o nome da empresa para uso no HTML
$empresa_nome = $_SESSION['empresa_nome'] ?? 'Empresa';
$empresa_id = $_SESSION['empresa_id'];
$link_avaliacao = $_SERVER['HTTP_HOST'] . '/cliente_avaliacao.php?id=' . $empresa_id;

// Funções de banco de dados (assumidas como existentes no bd_conexao.php)
// $avaliacoes = select_avaliacoes($empresa_id);
// $result_media = nota_media($empresa_id);
// $result_maior = maior_nota($empresa_id);
// $result_menor = menor_nota($empresa_id);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliações - OpineAqui - <?php echo $empresa_nome; ?></title>
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
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="empresa_alterar.php">Alterar dados cadastrais</a>
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

    <main class="container shadow px-2 my-2 bg-body rounded vh-100" style="max-height: calc(100vh - 150px);">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande">
                <img src="../images/logo.png" alt="OpineAqui - Logotipo Grande">
            </div>
            <hr>
            <div class="col-12 text-center">
                <h1>Avaliações da empresa: <?php echo htmlspecialchars($empresa_nome); ?></h1>

                <p>
                    <br>
                    Envie este link para seus clientes avaliarem sua empresa:
                    <a href="<?php echo htmlspecialchars('/cliente_avaliacao.php?id=' . $empresa_id); ?>" target="_blank" aria-label="Link de avaliação. Abre em nova aba.">
                        <?php echo htmlspecialchars($link_avaliacao); ?>
                    </a>
                </p><br>

                <?php
                // Os resultados das funções (select_avaliacoes, nota_media, etc.) devem ser executados aqui,
                // mas vou apenas simular a obtenção dos dados para manter o foco na correção do HTML/PHP
                $avaliacoes = select_avaliacoes($empresa_id); // Assumindo que esta função está definida
                ?>

                <div class="container" role="region" aria-label="Estatísticas das Avaliações">
                    <h3>Estatísticas Principais</h3>
                    <div class="row d-flex justify-content-center gap-5 text-center">
                        <?php
                        // Função para exibir resultados (simplificada)
                        function exibir_estatistica($result, $titulo, $cor) {
                            $valor = "Não foi possível determinar.";
                            if ($result && $row = $result->fetch_assoc()) {
                                // O nome da coluna deve ser o correto do banco (ajuste conforme necessário)
                                $coluna = ($titulo === 'Nota média') ? 'media_ponderada' : (($titulo === 'Maior nota') ? 'maior_nota' : 'menor_nota');
                                $valor = htmlspecialchars($row[$coluna] ?? 'N/D');
                            }
                            // ⚠️ Acessibilidade: Utilização de tags HTML semânticas e cores contrastantes
                            echo "<div class='col-12 col-md-3 shadow-sm' style='background-color:{$cor}; border-radius: 5px; padding: 5px; margin-bottom: 10px; color: #f0f0f0;'>";
                            echo "<p><strong>{$titulo}:</strong> <span aria-live='polite'>{$valor}</span></p>"; // aria-live para leitores de tela se o valor for atualizado
                            echo "</div>";
                        }
                        // Chamadas das funções (ajuste os nomes das funções e variáveis conforme seu bd_conexao.php)
                        exibir_estatistica(nota_media($empresa_id), 'Nota média', '#0d6efd');
                        exibir_estatistica(maior_nota($empresa_id), 'Maior nota', '#198754');
                        exibir_estatistica(menor_nota($empresa_id), 'Menor nota', '#dc3545');
                        ?>
                    </div>
                </div>

                <div class="container-fluid" role="region" aria-label="Tabela de Avaliações Detalhadas">
                    <div class="table-responsive overflow-auto" style="max-height: calc(100vh - 450px); width: 100%;">
                        <?php
                        if ($avaliacoes && $avaliacoes->num_rows > 0) {
                            echo "<div class='col h-100'>";
                            // ⚠️ Acessibilidade: Utilização de <caption> para descrever o conteúdo da tabela
                            echo "<table class='table table-striped table-hover mt-4'><caption>Lista de avaliações recebidas pela empresa {$empresa_nome}</caption>";
                            echo "<thead><tr>"; // ⚠️ Acessibilidade: Uso de <thead> para cabeçalho da tabela
                            echo "<th>Nome do Cliente</th>";
                            echo "<th>E-mail</th>";
                            echo "<th>Telefone</th>";
                            echo "<th>Data do Atendimento</th>";
                            echo "<th>Nota</th>";
                            echo "<th>Comentário</th>";
                            // ⚠️ Acessibilidade: Nome de coluna mais claro para a autorização
                            echo "<th>Autorização Marketing (Uso de Dados)</th>";
                            echo "</tr></thead>";
                            echo "<tbody>"; // ⚠️ Acessibilidade: Uso de <tbody> para o corpo da tabela

                            while ($row = $avaliacoes->fetch_assoc()) {
                                echo "<tr>";
                                // ⚠️ Acessibilidade: Uso de htmlspecialchars para prevenir XSS e garantir a correta exibição de caracteres especiais.
                                echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["celular"]) . "</td>";
                                // ⚠️ Melhoria: Formatar data para exibição no formato DD/MM/AAAA
                                $data_formatada = date('d/m/Y', strtotime($row["data_atendimento"]));
                                echo "<td>" . $data_formatada . "</td>";
                                echo "<td>" . htmlspecialchars($row["nota"]) . "</td>";
                                // ⚠️ Acessibilidade: Garantir que comentários longos quebrem a linha (pode ser feito via CSS)
                                echo "<td>" . htmlspecialchars($row["comentario"]) . "</td>";
                                $autorizacao_marketing = $row["autorizacao_marketing"] ? 'Sim' : 'Não'; // Mensagem clara
                                echo "<td>" . $autorizacao_marketing . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody></table>";
                            echo "</div>";
                        } else {
                            // ⚠️ Acessibilidade: Uso de elemento de parágrafo (p) para a mensagem
                            echo "<p class='my-5' role='alert'>Você ainda não possui avaliações.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer role="contentinfo">
        </footer>
    </body>
</html>
