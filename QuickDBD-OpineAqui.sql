-- Exported from QuickDBD: https://www.quickdatabasediagrams.com/
-- Link to schema: https://app.quickdatabasediagrams.com/#/d/9s3pTS
-- NOTE! If you have used non-SQL datatypes in your design, you will have to change these here.

-- Mapa Entidade Relacionamento OpineAqui

CREATE TABLE `Cliente` (
    `ClienteId` int  NOT NULL ,
    -- Preenchimento opcional pelo cliente
    `Name` varchar  NULL ,
    -- Preenchimento opcional pelo cliente
    `EmailCliente` varchar  NULL ,
    -- Preenchimento opcional pelo cliente
    `Celular` int  NULL ,
    `AutorizMarkt` boolean  NOT NULL ,
    PRIMARY KEY (
        `ClienteId`
    )
);

CREATE TABLE `Avaliacao` (
    `AvalID` int  NOT NULL ,
    `ClienteId` int  NOT NULL ,
    `EmpresaId` int  NOT NULL ,
    `DataAtendimento` date  NOT NULL ,
    `Nota` int  NOT NULL ,
    -- Preenchimento opcional pelo cliente
    `Comentario` varchar  NULL ,
    PRIMARY KEY (
        `AvalID`
    )
);

CREATE TABLE `Empresa` (
    `EmpresaId` int  NOT NULL ,
    `CNPJ` varchar  NOT NULL ,
    -- Nome da empresa no mercado
    `Nome` varchar  NOT NULL ,
    -- Descricao da atividade - opcional pela empresa
    `Descricao` varchar  NULL ,
    `EmailEmpresa` varchar  NOT NULL ,
    `Senha` varchar  NOT NULL ,
    -- Conforme dados CNPJ
    `RazaoSocial` varchar  NOT NULL ,
    `Endereco` varchar  NOT NULL ,
    -- Atividade principal CNPJ
    `Atividade` varchar  NOT NULL ,
    -- Data de cadastro no OpineAqui
    `DataCadastro` date  NOT NULL ,
    -- Indica empresa ativa no OpineAqui
    `Ativa` boolean  NOT NULL ,
    -- Data inativacao empresa no OpineAqui
    `DataInativacao` date  NULL ,
    PRIMARY KEY (
        `EmpresaId`
    )
);

ALTER TABLE `Avaliacao` ADD CONSTRAINT `fk_Avaliacao_ClienteId` FOREIGN KEY(`ClienteId`)
REFERENCES `Cliente` (`ClienteId`);

ALTER TABLE `Avaliacao` ADD CONSTRAINT `fk_Avaliacao_EmpresaId` FOREIGN KEY(`EmpresaId`)
REFERENCES `Empresa` (`EmpresaId`);

