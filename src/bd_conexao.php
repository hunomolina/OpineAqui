<?php
date_default_timezone_set('America/Sao_Paulo');

$serverName = "db";
$databaseName = "opine_aqui";
$dbUsername = "root";
$dbPassword = "root";
$dbPort = 3306;

$conn = new mysqli($serverName, $dbUsername, $dbPassword, $databaseName, $dbPort);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function dados_empresa($id_empresa) {
    global $conn;
    $query = $conn->query("SELECT * FROM Empresa WHERE id = $id_empresa");
    return $query;
}


function nome_empresa($id_empresa) {
    global $conn;
    $query = $conn->query("SELECT nome FROM Empresa WHERE id = $id_empresa AND status_ativo = 1");
    if ($query->num_rows > 0) {
        return $query->fetch_object()->nome;
    } else {
        return "NÃO LOCALIZADA";
    }
}


function lista_empresas() {
    global $conn;
    $query = $conn->query("SELECT nome,id FROM Empresa WHERE status_ativo = 1");
    return $query;
}


function select_avaliacoes($id_empresa) {
    global $conn;
    $query = $conn->query(
        "SELECT 
            c.nome,
            c.email,
            c.celular,
            a.data_atendimento,
            a.nota,
            a.comentario,
            c.autorizacao_marketing
        FROM `Avaliacao` AS a
        LEFT JOIN Cliente AS c
        ON c.id = a.id_cliente
        WHERE a.id_empresa = $id_empresa
        ORDER BY a.data_atendimento DESC
    ");
    return $query;
}


function cadastrar_cliente($email=null, $nome=null, $celular=null, $autorizacao_marketing=null) {
    global $conn;

    if ($email != "" && $email != null) {
        $check_email = $conn->query("SELECT id FROM `Cliente` WHERE email = '$email'");
    }
    else {
        return;
    }
    if ($check_email->num_rows > 0) {
        $id_cliente = $check_email->fetch_object()->id;
        $conn->query(
            "UPDATE Cliente 
            SET 
                nome = '$nome', 
                celular = '$celular', 
                autorizacao_marketing = $autorizacao_marketing 
            WHERE id = $id_cliente"
        );
        return $id_cliente;
    }
    else {
        $conn->query(
            "INSERT INTO Cliente (email, nome, celular, autorizacao_marketing)
            VALUES ('$email', '$nome', '$celular', $autorizacao_marketing);"
        );
        return $conn->insert_id;
    }
}


function cadastrar_avaliacao($id_empresa, $data_atendimento, $nota, $comentario, $id_cliente="NULL") {
    global $conn;
    $conn->query(
        "INSERT INTO Avaliacao (id_empresa, data_atendimento, nota, comentario, id_cliente)
        VALUES ($id_empresa, '$data_atendimento', $nota, '$comentario', $id_cliente);"
        );
    return;
}


function cadastrar_empresa($cnpj, $email, $nome, $descricao, $senha, $endereco) {
    global $conn;
    $query = $conn->query("SELECT id FROM Empresa WHERE cnpj = $cnpj OR email = '$email'");
    if ($query->num_rows > 0) {
        echo "CNPJ ou e-mail já existentes na base. Faça o login.";
        return false;
    }
    $conn->query(
        "INSERT INTO Empresa (cnpj, email, nome, descricao, senha, endereco)
        VALUES ($cnpj, '$email', '$nome', '$descricao', '$senha', '$endereco');"
        );
        $_SESSION['empresa_id'] = $conn->insert_id;
        $_SESSION['empresa_nome'] = $nome;
    return true;
    
}


function alterar_empresa($id_empresa, $cnpj, $email, $nome, $descricao, $senha, $endereco) {
    global $conn;
    $conn->query(
        "UPDATE Empresa 
        SET 
            cnpj = $cnpj,
            nome = '$nome', 
            email = '$email', 
            descricao = '$descricao', 
            senha = '$senha', 
            endereco = '$endereco'
        WHERE id = $id_empresa"
    );
    $_SESSION['empresa_nome'] = $nome;
    return true;
}

function inativar_empresa($id_empresa) {
    global $conn;
    $conn->query(
        "UPDATE Empresa
        SET 
            status_ativo = 0
            -- ,data_alteracao = date('Y-m-d\TH:i')
        WHERE id = $id_empresa"
    );
    return true;
}


function logon_empresa($email, $senha) {
    global $conn;
    $query = $conn->query("SELECT id, cnpj, nome, status_ativo FROM Empresa WHERE email = '$email' AND senha = '$senha'");
    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        $_SESSION['empresa_id'] = $row['id'];
        $_SESSION['empresa_nome'] = $row['nome'];
        if ($row['status_ativo'] == 0) {
            $conn->query(
                "UPDATE Empresa
                SET 
                    status_ativo = 1
                    -- ,data_alteracao = date('Y-m-d\TH:i')
                WHERE id = {$row['id']}"
            );
        } 
        return true;
    }
    else {
        return false;
    }
}

function maior_nota($id_empresa) {
    global $conn;
    $query = $conn->query(

        "SELECT 
        MAX(nota) as maior_nota
        FROM (
        SELECT 
            a.nota
        FROM Avaliacao AS a
        JOIN Empresa AS e ON a.id_empresa = e.id
        WHERE e.id = $id_empresa
        GROUP BY e.nome, a.nota) AS nota_agrupada");
    return $query;
}

function menor_nota($id_empresa) {
    global $conn;
    $query = $conn->query(

        "SELECT 
        MIN(nota) as menor_nota
        FROM (
        SELECT 
            a.nota
        FROM Avaliacao AS a
        JOIN Empresa AS e ON a.id_empresa = e.id
        WHERE e.id = $id_empresa
        GROUP BY e.nome, a.nota) AS nota_agrupada");
    return $query;
}

function nota_media($id_empresa) {
    global $conn;
    $query = $conn->query(

        "SELECT 
        nome_empresa,
        SUM(nota * quantidade) / SUM(quantidade) AS media_ponderada

        FROM (
        SELECT 
            e.nome AS nome_empresa,
            a.nota,
            COUNT(*) AS quantidade
        FROM Avaliacao AS a
        JOIN Empresa AS e ON a.id_empresa = e.id
        WHERE e.id = $id_empresa
        GROUP BY e.nome, a.nota

        ) AS nota_agrupada

");
    return $query;
}