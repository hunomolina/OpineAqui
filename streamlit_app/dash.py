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

import streamlit as st
import pandas as pd
import mysql.connector # Use the official MySQL connector which is compatible with MariaDB

# --- A. Session State Management ---

if 'user_id' not in st.session_state:
    st.session_state['user_id'] = None
    
current_session_id = st.session_state['user_id']
new_id_from_url = st.query_params.get("user_id", [None])[0]

# Logic to handle initial login/redirect and set the stable session ID
if new_id_from_url and new_id_from_url != str(current_session_id):
    try:
        new_user_id = int(new_id_from_url)
        st.session_state['user_id'] = new_user_id
        st.query_params.clear() 
        st.rerun()
    except ValueError:
        st.error("Invalid 'user_id' format in the URL.")
        st.stop()
        
# Block unauthenticated access
if current_session_id is None:
    st.warning("Dashboard access requires a user ID from the login page.")
    st.stop()
    
# --- B. MariaDB Query Function with Caching ---

# Caching is crucial. The function runs only once per unique user ID per hour.
@st.cache_data(ttl=3600, show_spinner="Querying MariaDB for personalized data...")
def get_user_data_from_mariadb(user_id_to_filter):
    """Connects to MariaDB, executes a filtered query, and returns a DataFrame."""
    
    # 1. Establish connection using st.secrets
    try:
        conn = mysql.connector.connect(
            host=st.secrets["mariadb"]["host"],
            port=st.secrets["mariadb"]["port"],
            database=st.secrets["mariadb"]["database"],
            user=st.secrets["mariadb"]["user"],
            password=st.secrets["mariadb"]["password"]
        )
    except Exception as e:
        st.error(f"Failed to connect to MariaDB. Check your .streamlit/secrets.toml. Error: {e}")
        return pd.DataFrame()

    # 2. Define the Query with Parameterization
    # Always use parameterized queries (placeholders) to prevent SQL Injection attacks.
    query = """
            SELECT 
                a.data_atendimento,
                a.comentario,
                a.nota
            FROM Avaliacao AS a
            INNER JOIN Empresa AS e ON a.id_empresa = e.id
            WHERE a.data_atendimento BETWEEN "2025-01-01" AND "2025-12-31"
            AND e.id = %s   
    """
    
    # 3. Execute the query and load results into a DataFrame
    try:
        # Use pandas.read_sql for a simple and efficient way to query to DataFrame
        # The params argument securely passes the user_id to the query.
        df = pd.read_sql(query, conn, params=(user_id_to_filter,))
        return df
    
    except Exception as e:
        st.error(f"Error executing MariaDB query: {e}")
        return pd.DataFrame()
    finally:
        # 4. Close the connection
        if conn.is_connected():
            conn.close()

# --- C. Display Dashboard ---

st.header(f"📈 Sales Dashboard for User: {current_session_id}")

# Call the cached function with the stable ID




# 1. Carregar Dados Filtrados
df_avaliacoes = get_user_data_from_mariadb(st.session_state['user_id'])

if not df_avaliacoes.empty:
    
    # 2. Exibir KPIs
    st.header("Resumo de Desempenho")
    col1, col2, col3, col4, col5 = st.columns(5)
    
    # Calculate metrics
    media_geral = df_avaliacoes['nota'].mean()

    promoters = len(df_avaliacoes[df_avaliacoes['nota'] >= 9])
    detractors = len(df_avaliacoes[df_avaliacoes['nota'] <= 6])
    total_responses = len(df_avaliacoes)
    
    if total_responses > 0:
        nps_score = ((promoters - detractors) / total_responses) * 100
    else:
        nps_score = 0.0
    
    col1.metric("Média Geral", f"{media_geral:.2f}")
    col2.metric("Maior Nota", df_avaliacoes['nota'].max())
    col3.metric("Total de Reviews", len(df_avaliacoes))
    col4.metric("NPS", f"{nps_score:.0f}%")

    with col5:
        if nps_score >= 75:
            st.badge("Excelência", icon="❤️", color="red")
        elif nps_score >= 50:
            st.badge("Muito bom", icon=":material/check:", color="green")
        elif nps_score >= 20:
            st.markdown(":orange-badge[⚠️ Atenção]"
        )  
        else:
            st.markdown(":red-badge[❌ Crítico]")    

    
    st.markdown("---")
    
    # 3. Plot da Média Móvel (Séries Temporais)
    st.subheader("Satisfação ao Longo do Tempo")
    
    # Configurar os dados para plotagem (calculando a média diária e média móvel)
    df_plot = df_avaliacoes.copy()
    df_plot['data'] = pd.to_datetime(df_plot['data_atendimento'])
    df_tendencia = df_plot.set_index('data')['nota'].resample('D').mean().fillna(method='ffill')
    df_tendencia = df_tendencia.rolling(window=7).mean() # Média Móvel de 7 dias

    st.line_chart(df_tendencia)
    
    st.markdown("---")

    # 4. Distribuição de Notas
    st.subheader("Frequência de Notas")
    nota_counts = df_avaliacoes['nota'].value_counts().sort_index()
    st.bar_chart(nota_counts)

    st.markdown("---")
    
    # 5. Tabela de Avaliações Recentes
    st.subheader("Últimas Avaliações")
    st.dataframe(df_avaliacoes.tail(10)) 
else:
    st.warning(f"No personalized data found for User ID {current_session_id}.")