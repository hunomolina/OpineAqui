<?php
header('Content-Type: application/json');

if (isset($_GET['cnpj'])) {
    $cnpj_limpo = preg_replace('/[^0-9]/', '', $_GET['cnpj']);
    $apiUrl = "https://publica.cnpj.ws/cnpj/" . $cnpj_limpo;

    $response = @file_get_contents($apiUrl);
    echo $response;

} else {
    http_response_code(400);
    echo json_encode(['erro' => 'CNPJ não fornecido.']);
}