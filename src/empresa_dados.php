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
            <a href="index.html">
                <img src="../images/logo.png" alt="logo" class="logo">
            </a>
            <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
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
                </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container shadow px-2 my-2 bg-body rounded">
        <div class="row">
            <div class="d-flex justify-content-center logo-grande"><img src="../images/logo.png" alt="logo"></div>
            <hr> 
            <div class="col-12 text-center">
                <h2>Avaliações da empresa: <? echo $_SESSION['empresa_nome']; ?></h2>    
                <p>Envie este link para seus clientes avaliarem sua empresa: 
                    <a href="<?php echo '/cliente_avaliacao.php?id=' . $_SESSION['empresa_id']; ?>" target="_blank"><?php echo $_SERVER['HTTP_HOST'] . '/cliente_avaliacao.php?id=' . $_SESSION['empresa_id']; ?></a>
                </p>

                <?php
                $avaliacoes = select_avaliacoes($_SESSION['empresa_id']);
                ?>
                
                <div class="container">
                    <div class="row d-flex justify-content-center gap-5 text-center">
                        <div class="col-12 col-md-3 shadow-sm" style="background-color:#0d6efd; border-radius: 5px; padding: 5px; margin-bottom: 10px; color: #f0f0f0;">
                            <?php
                            $result = nota_media($_SESSION['empresa_id']);
                            if ($result && $row = $result->fetch_assoc()) {
                                echo "<span><strong>Nota média:</strong> " . $row['media_ponderada'] . "</span>";
                            } else {
                                echo "<p><strong>Nota média:</strong> Não foi possível determinar.</p>";
                            }
                            ?>
                        </div>
                        <div class="col-12 col-md-3 shadow-sm" style="background-color:#198754; border-radius: 5px; padding: 5px; margin-bottom: 10px; color: #f0f0f0;">
                            <?php
                            $result = maior_nota($_SESSION['empresa_id']);
                            if ($result && $row = $result->fetch_assoc()) {
                                echo "<span><strong>Maior nota:</strong> " . $row['maior_nota'] . "</span>";
                            } else {
                                echo "<p><strong>Maior nota:</strong> Não foi possível determinar.</p>";
                            }
                            ?>
                        </div>
                        <div class="col-12 col-md-3 shadow-sm" style="background-color:#dc3545; border-radius: 5px; padding: 5px; margin-bottom: 10px; color: #f0f0f0;">
                            <?php
                            $result = menor_nota($_SESSION['empresa_id']);
                            if ($result && $row = $result->fetch_assoc()) {
                                echo "<span><strong>Menor nota:</strong> " . $row['menor_nota'] . "</span>";
                            } else {
                                echo "<p><strong>Menor nota:</strong> Não foi possível determinar.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="table-responsive table-scroll" style="max-height: 360px; overflow-y: auto;">
                        <?php
                        if ($avaliacoes->num_rows > 0) {
                            echo "<table class='table table-striped table-hover mt-4'>";
                            echo "<tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Telefone</th>
                                    <th>Data do Atendimento</th>
                                    <th>Nota</th>
                                    <th>Comentário</th>
                                    <th>Autorização Marketing</th>
                                </tr>";
                            while ($row = $avaliacoes->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["nome"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["celular"] . "</td>";
                                echo "<td>" . $row["data_atendimento"] . "</td>";
                                echo "<td>" . $row["nota"] . "</td>";
                                echo "<td>" . $row["comentario"] . "</td>";
                                echo "<td>" . ($row["autorizacao_marketing"] ? 'Sim' : '') . "</td>";
                                echo "</tr>";
                            }
                            echo "</tr>";
                        } else {
                            echo "<div class='my-5'>Você ainda não possui avaliações.</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- <footer class="footer-fixo" style="background-color: #f5f5f5; padding-right: 650px;">
        <p>&copy; <span id="anoAtual"></span> Projeto Integrador - UNIVESP. Todos os direitos reservados.</p>
    </footer> -->
</body>

</html>