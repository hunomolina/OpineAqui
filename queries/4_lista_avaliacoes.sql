-- Lista avaliacoes de uma empresa num intervalo de tempo
USE opine_aqui;

SET @id_empresa = 1;
SET @data_inicio = "2025-01-01";
SET @data_fim = "2025-12-31";
SELECT 
e.nome AS empresa,
date_format(a.data_atendimento, '%d/%m/%Y') AS dt_atendimento,
date_format(a.data_criacao, '%d/%m/%Y') AS dt_criacao,
c.nome AS nome,
a.nota AS nota,
a.comentario AS comentario
from Avaliacao AS a

JOIN Empresa AS e 
ON a.id_empresa = e.id

LEFT JOIN Cliente as c
ON a.id_cliente = c.id

WHERE a.data_atendimento BETWEEN @data_inicio AND @data_fim
AND e.id = @id_empresa

ORDER BY a.data_atendimento DESC