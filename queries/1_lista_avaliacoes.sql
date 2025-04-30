-- Lista avaliacoes de uma empresa num intervalo de tempo
use opine_aqui;
SET @id_empresa = 1;
SET @data_inicio = "2025-01-01";
SET @data_fim = "2025-12-31";

select 
e.nome as empresa,
date_format(a.data_atendimento, '%d/%m/%Y') as dt_atendimento,
date_format(a.data_criacao, '%d/%m/%Y') as dt_criacao,
c.nome as nome,
a.nota as nota,
a.comentario as comentario
from Avaliacao as a

join Empresa as e 
on a.id_empresa = e.id

left join Cliente as c
on a.id_cliente = c.id

WHERE a.data_atendimento BETWEEN @data_inicio AND @data_fim
AND e.id = @id_empresa

ORDER BY a.data_atendimento DESC
