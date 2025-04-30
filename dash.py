"""
Este script cria um painel Streamlit para exibir dados de avaliações e notas para o aplicativo OpineAqui
    - pandas: Para manipulação e análise de dados.
    - streamlit: Para criar a aplicação web interativa.
Fontes de Dados:
    - Lê dados de um arquivo Excel localizado em './queries/dados_dummy.xlsx' com duas planilhas:
        1. 'aval': Contém detalhes das avaliações.
        2. 'notas': Contém informações de notas e relacionadas.
Funcionalidades:
    - Exibe um título e um divisor para o painel.
    - Permite aos usuários selecionar uma empresa e um intervalo de datas usando um dropdown e um slider.
    - Calcula e exibe métricas:
        - Nota média ponderada.
        - Maior nota.
        - Menor nota.
        - Total de avaliações.
    - Exibe as últimas 10 avaliações em formato de tabela.
Funções:
    - Pré-processamento de dados:
        - Formata as colunas de data ('dt_atendimento', 'dt_criacao') para 'dd/mm/aaaa'.
        - Preenche valores ausentes na coluna 'nome' com "Não informado".
        - Calcula uma coluna 'produto' como o produto de 'nota' e 'quantidade'.
    - Interação com o usuário:
        - Dropdown para selecionar uma empresa.
        - Slider para selecionar um intervalo de datas.
    - Cálculo de métricas:
        - Filtra os dados com base na empresa selecionada e no intervalo de datas.
        - Calcula a nota média ponderada, maior nota, menor nota e total de avaliações.
    - Exibição de dados:
        - Mostra as métricas em um layout de grade.
        - Exibe uma tabela com as últimas 10 avaliações filtradas por empresa e intervalo de datas.
Uso:
    - Execute o script em um ambiente Streamlit para iniciar o painel.
    - Interaja com o dropdown e o slider para filtrar e visualizar os dados dinamicamente.
"""

import pandas as pd

import streamlit as st

df_aval = pd.read_excel("./queries/dados_dummy.xlsx", sheet_name="aval")
df_aval["dt_atendimento"] = df_aval["dt_atendimento"].dt.strftime("%d/%m/%Y")
df_aval["dt_criacao"] = df_aval["dt_criacao"].dt.strftime("%d/%m/%Y")
df_aval["nome"] = df_aval["nome"].fillna("Não informado")

df_notas = pd.read_excel("./queries/dados_dummy.xlsx", sheet_name="notas")
df_notas["dt_atendimento"] = df_notas["dt_atendimento"].dt.strftime("%d/%m/%Y")
df_notas["dt_criacao"] = df_notas["dt_criacao"].dt.strftime("%d/%m/%Y")
df_notas["produto"] = df_notas["nota"] * df_notas["quantidade"]


st.title("Dashboard de Avaliações")
st.divider()

col1, col2 = st.columns(2)
with col1:
    empresas = df_notas["empresa"].unique().tolist()
    opcoes = st.selectbox("Escolha uma empresa", empresas)

with col2:
    atendimento = df_notas["dt_atendimento"].unique().tolist()
    atendimento.sort()

    star_date, end_date = st.select_slider(
        "Selecione um intervalo de datas",
        options=atendimento,
        value=(atendimento[0], atendimento[-1]),
    )

nota_ponderada = (
    df_notas.loc[
        (df_notas["empresa"] == opcoes)
        & (df_notas["dt_atendimento"].between(star_date, end_date)),
        "produto",
    ].sum()
    / df_notas.loc[
        (df_notas["empresa"] == opcoes)
        & (df_notas["dt_atendimento"].between(star_date, end_date)),
        "quantidade",
    ].sum()
)

total_aval = df_notas.loc[
    (df_notas["empresa"] == opcoes)
    & (df_notas["dt_atendimento"].between(star_date, end_date)),
    "quantidade",
].sum()

nota_max = df_notas.loc[
    (df_notas["empresa"] == opcoes)
    & (df_notas["dt_atendimento"].between(star_date, end_date)),
    "nota",
].max()

nota_min = df_notas.loc[
    (df_notas["empresa"] == opcoes)
    & (df_notas["dt_atendimento"].between(star_date, end_date)),
    "nota",
].min()

col3, col4, col5, col6 = st.columns(4)
col3.metric(label="Nota média", value=f"{nota_ponderada:.1f}", border=True)
col4.metric(label="Maior nota", value=f"{nota_max:.1f}", border=True)
col5.metric(label="Menor nota", value=f"{nota_min:.1f}", border=True)
col6.metric(label="Total de avaliações", value=total_aval, border=True)

st.divider()
st.subheader(f"Últimas 10 avaliações")

df_exibicao = df_aval[["dt_atendimento", "nota", "nome", "comentario"]].rename(
    columns={
        "dt_atendimento": "Data do Atendimento",
        "nota": "Nota",
        "nome": "Nome do Cliente",
        "comentario": "Comentário",
    }
)

st.dataframe(
    df_exibicao.loc[
        (df_aval["empresa"] == opcoes)
        & (df_aval["dt_atendimento"].between(star_date, end_date))
    ].head(10),
    hide_index=True,
)
