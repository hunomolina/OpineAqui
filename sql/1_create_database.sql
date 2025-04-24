-- MariaDB script
DROP DATABASE IF EXISTS opine_aqui;
CREATE DATABASE opine_aqui;
USE opine_aqui;

DROP TABLE IF EXISTS Empresa;
CREATE TABLE Empresa (
    id INT NOT NULL AUTO_INCREMENT,
    cnpj CHAR(18) NOT NULL,
    email CHAR(50) NOT NULL,
    nome CHAR(100) NOT NULL,
    descricao CHAR(255) NOT NULL,
    senha CHAR(20) NOT NULL,
    endereco CHAR(200) NOT NULL,
    atividade CHAR(50) NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Cliente;
CREATE TABLE Cliente (
    id INT NOT NULL AUTO_INCREMENT,
    email CHAR(50),
    nome CHAR(100),
    celular CHAR(15),
    autorizacao_marketing BOOLEAN,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Avaliacao;
CREATE TABLE Avaliacao (
    id INT NOT NULL AUTO_INCREMENT,
    id_cliente INT,
    id_empresa INT NOT NULL,
    data_atendimento DATETIME NOT NULL,
    nota INT(2) NOT NULL,
    comentario CHAR(255),
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (id),
    FOREIGN KEY (id_cliente) REFERENCES Cliente(id),
    FOREIGN KEY (id_empresa) REFERENCES Empresa(id)
);