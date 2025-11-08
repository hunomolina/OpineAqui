"""
Este script cria um painel Streamlit para exibir dados de avaliações e notas para o aplicativo OpineAqui, 
personalizado para o ID de usuário logado (geralmente o ID da Empresa).
 
Tecnologias:
    - pandas: Para manipulação e análise de dados.
    - streamlit: Para criar a aplicação web interativa.
    - mysql.connector: Para conectar e consultar o banco de dados MariaDB/MySQL.

Fontes de Dados:
    - Conecta-se a um banco de dados MariaDB (configurado via st.secrets) e consulta a tabela 'Avaliacao', 
      filtrando pelo 'id' da Empresa associado ao 'user_id' na sessão.

Funcionalidades:
    - Gerenciamento de Estado de Sessão: Controla o acesso via 'user_id' e lida com a autenticação inicial via URL.
    - Cache Inteligente: Utiliza @st.cache_data para cachear os resultados da consulta ao banco por 1 hora (ttl=3600), 
      otimizando a performance.
    - **Filtro de Datas (Novo Local)**: Permite aos usuários selecionar um intervalo de datas (início e fim) para filtrar os dados, 
      localizado logo abaixo do título principal.
    - Exibe o título do painel, o nome da empresa e métricas-chave.
    - Calcula e exibe métricas: Média Geral, Maior Nota, Total de Avaliações e o **NPS (Net Promoter Score)**.
    - Exibe um gráfico de linha da Média Móvel de 7 dias das notas ao longo do tempo.
    - Exibe um gráfico de barras com a frequência de cada nota.
    - Exibe as últimas 10 avaliações filtradas em formato de tabela.

Uso:
    - Certifique-se de que as credenciais do MariaDB estejam configuradas em um arquivo .streamlit/secrets.toml.
    - Execute o script em um ambiente Streamlit (streamlit run seu_script.py) para iniciar o painel.
    - O acesso deve ser feito com um parâmetro '?user_id=X' na URL para inicializar a sessão.
    - Interaja com o seletor de datas para filtrar e visualizar os dados dinamicamente.
"""

import streamlit as st
import pandas as pd
import mysql.connector
from datetime import date
from typing import Tuple, List

# --- A. Session State Management (Gerenciamento de Estado de Sessão) ---

if 'user_id' not in st.session_state:
    st.session_state['user_id'] = None
    
current_session_id = st.session_state['user_id']
# Modificado para usar st.query_params.get para uma sintaxe mais limpa
new_id_from_url = st.query_params.get("user_id")

# Lógica para lidar com o login/redirecionamento inicial e definir o ID de sessão estável
if new_id_from_url and new_id_from_url != str(current_session_id):
    try:
        new_user_id = int(new_id_from_url)
        st.session_state['user_id'] = new_user_id
        st.query_params.clear() 
        st.rerun()
    except ValueError:
        st.error("Formato de 'user_id' inválido na URL.")
        st.stop()
        
# Bloquear acesso não autenticado
if current_session_id is None:
    st.warning("O acesso ao Dashboard requer um ID de usuário da página de login.")
    st.stop()
    
# --- B. MariaDB Query Function with Caching (Função de Consulta ao MariaDB com Cache) ---

# O cache é crucial. A função é executada apenas uma vez por ID de usuário exclusivo por hora.
@st.cache_data(ttl=3600, show_spinner="Consultando MariaDB para dados personalizados...")
def get_user_data_from_mariadb(user_id_to_filter: int) -> pd.DataFrame:
    """Conecta-se ao MariaDB, executa uma consulta filtrada e retorna um DataFrame."""
    
    # 1. Estabelecer conexão usando st.secrets
    try:
        conn = mysql.connector.connect(
            host=st.secrets["mariadb"]["host"],
            port=st.secrets["mariadb"]["port"],
            database=st.secrets["mariadb"]["database"],
            user=st.secrets["mariadb"]["user"],
            password=st.secrets["mariadb"]["password"]
        )
    except Exception as e:
        st.error(f"Falha ao conectar ao MariaDB. Verifique seu .streamlit/secrets.toml. Erro: {e}")
        return pd.DataFrame()

    # 2. Definir a Consulta com Parametrização
    query = """
            SELECT 
                e.nome,
                a.data_atendimento,
                a.comentario,
                a.nota
            FROM Avaliacao AS a
            INNER JOIN Empresa AS e ON a.id_empresa = e.id
            WHERE e.id = %s
    """
    
    # 3. Executar a consulta e carregar os resultados em um DataFrame
    try:
        df = pd.read_sql(query, conn, params=(user_id_to_filter,))
        return df
    
    except Exception as e:
        st.error(f"Erro ao executar a consulta MariaDB: {e}")
        return pd.DataFrame()
    finally:
        # 4. Fechar a conexão
        if 'conn' in locals() and conn.is_connected():
            conn.close()

# --- C. Display Dashboard (Exibir Dashboard) ---

# 1. Carregar Dados Filtrados
df_base = get_user_data_from_mariadb(st.session_state['user_id'])
empresa_nome = df_base['nome'].iloc[0] if not df_base.empty else "Empresa"

st.header(f"📈 Dashboard {empresa_nome}")

if not df_base.empty:
# --- D. Pré-processamento e Filtro de Datas ---
    
    # Conversão de Tipo (Crucial para o filtro de data)
    df_base['data_atendimento'] = pd.to_datetime(df_base['data_atendimento'])
    
    # Determinar as datas mínima e máxima para o seletor
    min_date = df_base['data_atendimento'].min().date()
    max_date = df_base['data_atendimento'].max().date()
    default_start_date = min_date
    default_end_date = max_date
    
    # 1. Filtro de Datas na Área Principal (Usando 3 colunas para centralizar)
    
    # Definindo 3 colunas: 1 para o espaço à esquerda, 2 para o widget centralizado, 3 para o espaço à direita.
    # A proporção [1, 2, 1] ou [1, 3, 1] costuma funcionar bem. Usaremos [1, 3, 1] para o widget ficar um pouco maior.
    col_left, col_center, col_right = st.columns([1, 3, 1])
    
    with col_center:
        # Centralizando o widget na coluna do meio
        data_range: Tuple[date] = st.date_input(
            "Selecione o Intervalo de Datas",
            value=(default_start_date, default_end_date),
            min_value=min_date,
            max_value=max_date,
            format="DD/MM/YYYY",
            key="date_filter_main_body" 
        )
        
    # A linha de separação deve ser fora das colunas para pegar a largura total
    st.markdown("---") 

    # Lógica para extrair as datas
    if len(data_range) == 2:
        start_date, end_date = data_range
    else:
        start_date = min_date
        end_date = max_date


    # 2. Aplicar Filtro
    df_avaliacoes = df_base[
        (df_base['data_atendimento'].dt.date >= start_date) & 
        (df_base['data_atendimento'].dt.date <= end_date)
    ].copy() 
    
    
    if df_avaliacoes.empty:
        st.warning(f"Não há dados disponíveis para o período de {start_date.strftime('%d/%m/%Y')} a {end_date.strftime('%d/%m/%Y')}.")
        st.stop()
        
    
    # --- E. Exibir KPIs e Gráficos (Baseado em df_avaliacoes) ---
    
    # 3. Exibir KPIs (Resumo de Desempenho)
    st.header("Resumo de Desempenho") # Este é o ponto que você queria o filtro ANTES
    col1, col2, col3, col4, col5 = st.columns(5)
    
    # Calcular métricas
    media_geral = df_avaliacoes['nota'].mean()

    # Cálculo do NPS (Net Promoter Score)
    promoters = len(df_avaliacoes[df_avaliacoes['nota'] >= 9])
    detractors = len(df_avaliacoes[df_avaliacoes['nota'] <= 6])
    total_responses = len(df_avaliacoes)
    
    if total_responses > 0:
        nps_score = ((promoters - detractors) / total_responses) * 100
    else:
        nps_score = 0.0
    
    col1.metric("Média Geral", f"{media_geral:.2f}")
    col2.metric("Maior Nota", df_avaliacoes['nota'].max())
    col3.metric("Total de Avaliações", len(df_avaliacoes))
    col4.metric("NPS", f"{nps_score:.0f}%")

    with col5:
        if nps_score >= 75:
            st.badge("Excelência", icon="❤️", color="red")
        elif nps_score >= 50:
            st.badge("Muito Bom", icon=":material/check:", color="green")
        elif nps_score >= 20:
            st.markdown(":orange-badge[⚠️ Atenção]") 
        else:
            st.markdown(":red-badge[❌ Crítico]") 

    
    st.markdown("---")
    
    # 4. Plot da Média Móvel (Séries Temporais)
    st.subheader("Média Móvel das Avaliações (7 dias)")
    
    df_tendencia = df_avaliacoes.set_index('data_atendimento')['nota'].resample('D').mean().fillna(method='ffill')
    df_tendencia = df_tendencia.rolling(window=7).mean() 

    st.line_chart(df_tendencia)
    
    st.markdown("---")

    # 5. Distribuição de Notas
    st.subheader("Frequência de Notas")
    nota_counts = df_avaliacoes['nota'].value_counts().sort_index()
    st.bar_chart(nota_counts, use_container_width=True)

    st.markdown("---")
    
    # 6. Tabela de Avaliações Recentes
    st.subheader("Últimas Avaliações (10 Mais Recentes)")
    df_display = df_avaliacoes[['data_atendimento', 'nota', 'comentario']].tail(10)
    df_display.columns = ['Data', 'Nota', 'Comentário']
    
    df_display['Data'] = df_display['Data'].dt.strftime('%d/%m/%Y')
    
    st.dataframe(df_display, use_container_width=True) 

else:
    st.warning(f"Nenhum dado personalizado encontrado para o ID de Usuário {current_session_id}.")