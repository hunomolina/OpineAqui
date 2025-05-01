-- Soma quantidade de empresas cadastradas por status
USE opine_aqui;

SELECT 
COUNT(id) AS qtde,
status_ativo AS ativo
FROM Empresa
