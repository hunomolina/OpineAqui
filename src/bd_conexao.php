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


function lista_empresas() {
    global $conn;
    $query = $conn->query("SELECT nome,id FROM Empresa");
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
    ");
    return $query;
}


function cadastrar_cliente($email=null, $nome=null, $celular=null, $autorizacao_marketing=null) {
    global $conn;
    //verifica se cliente forneceu dado de e-mail
    if ($email != "" && $email != null) {
        //verifica se cliente existe na base de dados
        $check_email = $conn->query("SELECT id FROM `Cliente` WHERE email = '$email'");
    }
    else {
        return;
    }
    if ($check_email->num_rows > 0) {
        //se já existir obtém seu id e altera dados do cliente
        $id_cliente = $check_email->fetch_object()->id;
        $conn->query(
            "UPDATE Cliente 
            SET 
                email = '$email',
                nome = '$nome', 
                celular = '$celular', 
                autorizacao_marketing = $autorizacao_marketing 
            WHERE id = $id_cliente"
        );
        return $id_cliente;
    }
    else {
        //se não existir, cadastra novo cliente
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


function cadastrar_empresa($cnpj, $email, $nome, $descricao, $senha, $endereco, $atividade) {
    //verificar se empresa já existe na base de dados
    //se já existir, pegar id
    //se não existir, cadastrar nova empresa, pegar id e jogar id na session state

    global $conn;
    $query = $conn->query("SELECT id FROM Empresa WHERE cnpj = $cnpj");
    if ($query->num_rows > 0) {
        echo "Empresa já cadastrada. Faça o login";
        return false;
    }
    $conn->query(
        "INSERT INTO Empresa (cnpj, email, nome, descricao, senha, endereco, atividade)
        VALUES ($cnpj, '$email', '$nome', '$descricao', '$senha', '$endereco', '$atividade');"
        );
        $_SESSION['empresa_id'] = $conn->insert_id;
    return true;
    
}


function alterar_empresa($id_empresa, $cnpj, $email, $nome, $descricao, $senha, $endereco, $atividade) {
    global $conn;
    $conn->query(
        "UPDATE Empresa 
        SET 
            cnpj = $cnpj,
            nome = '$nome', 
            email = '$email', 
            descricao = '$descricao', 
            senha = '$senha', 
            endereco = '$endereco',
            atividade = '$atividade' 
        WHERE id = $id_empresa"
    );
    $_SESSION['empresa_nome'] = $nome;
    return true;
}


function logon_empresa($email, $senha) {
    global $conn;
    $query = $conn->query("SELECT id, cnpj, nome FROM Empresa WHERE email = '$email' AND senha = '$senha'");
    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        $_SESSION['empresa_id'] = $row['id'];
        $_SESSION['empresa_nome'] = $row['nome'];
        // $_SESSION['empresa_cnpj'] = $row['cnpj'];
        // $id_empresa = $query->fetch_object()->id;
        return true;
    }
    else {
        return false;
    }
}

?>