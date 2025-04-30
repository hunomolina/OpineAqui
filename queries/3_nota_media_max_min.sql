USE opine_aqui;

SET @id_empresa = 1;
SET @data_inicio = "2025-01-01";
SET @data_fim = "2025-12-31";

SELECT 
    nome_empresa,
    SUM(nota * quantidade) / SUM(quantidade) AS media_ponderada,
    max(nota) as nota_maxima,
    min(nota) as nota_minima
FROM (
    SELECT 
        e.nome AS nome_empresa,
        a.nota,
        COUNT(*) AS quantidade
    FROM Avaliacao AS a
    JOIN Empresa AS e ON a.id_empresa = e.id
    WHERE a.data_atendimento BETWEEN @data_inicio AND @data_fim
      AND e.id = @id_empresa
    GROUP BY e.nome, a.nota

) AS nota_agrupada

GROUP BY nome_empresa
ORDER BY nome_empresa DESC