USE opine_aqui;

INSERT INTO Empresa (cnpj, email, nome, descricao, senha, endereco, atividade)
VALUES  (11111111000111, "11@teste.com", "Empresa Um", "Empresa criada para testes", "123456", "Rua Um, n. 1, Bairro Um, São Paulo/SP, CEP 11111-111", "Comércio de bolos artesanais"),
        (22222222000222, "22@teste.com", "Empresa Dois", "Empresa Dois para testes", "123456", "Rua Dois, n. 2, Bairro Dois, São Paulo/SP, CEP 22222-222", "Manicure e pedicure");

INSERT INTO Cliente (email, nome, celular, autorizacao_marketing)
VALUES  ("fulano@teste.com", "Fulano de Tal", "11-111111111", 1),
        ("cicrano@teste.com", "Cicrano de Tal", "11-222222222", 1);

INSERT INTO Avaliacao (id_cliente, id_empresa, data_atendimento, nota, comentario)
VALUES  (1, 1, "2025-04-17 12:45:00", 10, "Muito bom, recomendo!"),
        (1, 2, "2025-03-12 11:00:00", 7, "Pessoal mal humorado!"),
        (2, 2, "2025-01-11 10:00:00", 1, "Péssimo!"),
        (NULL,1,"2025-01-17 20:00:00", 9, "Gostei bastante do atendimento.");