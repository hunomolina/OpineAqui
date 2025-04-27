-- MariaDB script
DROP DATABASE IF EXISTS opine_aqui;
CREATE DATABASE opine_aqui;
USE opine_aqui;

DROP TABLE IF EXISTS Empresa;
CREATE TABLE Empresa (
    id INT NOT NULL AUTO_INCREMENT,
    cnpj VARCHAR(18) NOT NULL,
    email VARCHAR(50) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    senha VARCHAR(20) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    status_ativo BOOLEAN NOT NULL DEFAULT 1,
    data_alteracao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Cliente;
CREATE TABLE Cliente (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(50),
    nome VARCHAR(100),
    celular VARCHAR(15),
    autorizacao_marketing BOOLEAN,
    data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    data_alteracao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Avaliacao;
CREATE TABLE Avaliacao (
    id INT NOT NULL AUTO_INCREMENT,
    id_cliente INT,
    id_empresa INT NOT NULL,
    data_atendimento DATETIME NOT NULL,
    nota INT(2) NOT NULL,
    comentario VARCHAR(255),
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id),
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id),
    FOREIGN KEY (id_empresa) REFERENCES Empresa(id)
);