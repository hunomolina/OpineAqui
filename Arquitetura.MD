## OPINE AQUI

### **FRONT:**

**Landing Page:**

- Sobre o OpineAqui: informações gerais sobre a serviço oferecido
- Link para “Empresa - cadastro”
- Link para “Empresa - login”

**Empresa - cadastro:**

- cnpj (VARCHAR)
- data_alteracao (DATETIME)
- data_criacao (DATETIME)
- descricao (VARCHAR)
- email (VARCHAR)
- endereco (VARCHAR)
- nome (VARCHAR)
- senha (VARCHAR)
- status_ativo (BOOLEAN)

**Empresa - login:**

- email
- senha

**Empresa - alteração de cadastro (após logado):**

- email (VARCHAR)
- senha (VARCHAR)

**Empresa - visualização de dados (após logado):**

- Lista com avaliações
    - nome
    - e-mail
    - nota
    - Comentário
    - autorização para e-mail market (bool)
- Filtrar das avaliações
    - data ou período
    - nota atribuída
- Dashboard com informações extraídas dos dados
    - NPS x estrelas 1-5?
    - ver exemplo mercado livre
    - apresentar "avaliações recentes"
    - botão exportar dados?
- (avaliar) extrair lista com e-mails separados com “;” para envio de marketing por e-mail.

**Cliente**

**Coleta de feedback dos clientes.** Campos em formulário:

- e-mail (opcional)
- Nome (opcional)
- Celular (opcional)
- Empresa avaliada (dropdown)
- Data do atendimento
- Nota - 0 a 10
- Comentário
- Termos de privacidade
- (avaliar) Autorização para envio de marketing por e-mail (condicional, se e-mail foi informado)

Botão → Realiza POST do formulário para backend

### BACKEND

**Cliente - coleta de dados:**

- e-mail (char ou NULL)
- nome (char ou NULL)
- celular (int ou NULL)
- data do atendimento (date)
- nota (int)
- Comentário (varchar)
- (avaliar) Autorização mail marketing (bit)

**Empresa - cadastro:**

- CNPJ (char)
- Data de alteração (date)
- Data de criação (date)
- Descrição (char)
- E-mail (char)
- Endereço (char)
- Nome (char)
- Senha (char)
- Status (boolean)

### BASE SQL

**Cliente**

- id (pk)
- email - varchar/NULLABLE
- nome - varchar/NULLABLE
- celular - int/NULLABLE
- Data_cadastro - date
- autorizacao_marketing - boolean

**Avaliação**

- id (pk)
- id_cliente (fk)
- id_empresa (fk)
- data_atendimento - date
- nota - int
- comentario - varchar/NULLABLE

**Empresa**

- id (pk)
- cnpj - varchar
- email - varchar
- nome - varchar
- descricao - varchar
- senha - varchar
- endereço - varchar
- Data_cadastro - date
- ativa - boolean #se ativa no cadastro OpineAqui
- data de inativação - date


