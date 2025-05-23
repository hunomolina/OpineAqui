# OpineAqui
Plataforma de pesquisa de opinião com consumidores de pequenos negócios

## Descrição
A plataforma permite que empresas se cadastrem para que seus clientes possam realizar avaliações de seus produtos e serviços. 

As avaliações consistem na indicação de uma nota (0-10) e de uma observação a respeito do produto ou serviço. A identificação do cliente não é obrigatória e aqueles que se identificarem poderão optar por se inscrever em programa de marketing.

Os clientes podem realizar as avaliações por link específico gerado pela empresa, caso em que não será necessário identificá-la, ou acessando a homepage do OpineAqui. 

As empresas, uma vez logadas, terão acesso às avaliações feitas, bem como aos valores de nota média, máxima e mínima.

## Stack tecnológico
- MariaDB - banco de dados
- PHPMyAdmin - visualização e administração do banco de dados
- PHP-Apache - servidor de aplicação

## Como subir o ambiente de desenvolvimento

### Pressupostos
Instalar os seguintes aplicativos no seu Windows, Mac ou Linux:
1. [Docker Desktop](https://www.docker.com/products/docker-desktop/)
2. [GitHub Desktop](https://desktop.github.com/download/)
OBS: a sua conta github deverá ser vinculada ao GitHub Desktop

### Passo-a-passo

1. Clonar o repositório do GitHub. Pelo GitHub Desktop, utilizar as opções do aplicativo para clonar o repositório - [instruções](https://docs.github.com/pt/desktop/adding-and-cloning-repositories/cloning-and-forking-repositories-from-github-desktop).
2. Crie uma nova branch no GitHub, a partir da branch main - [instruções](https://docs.github.com/pt/desktop/making-changes-in-a-branch/managing-branches-in-github-desktop).
3. Acesse a pasta raiz do projeto pela linha de comando (pode ser do VS Code, por exemplo) e rodar o comando `docker compose up`. Esse comando subirá todos os containeres dockerer do stack e os manterá em execução até que seja encerrado pelo comando `docker compose down -v`. 
OBS: o comando -v apagará todos os registros feitos em banco de dados, que serão recriados a cada nova execução do `docker compose up`.

## Como usar o ambiente de desenvolvimento
1. Commit é o salvamento de uma versão do código. Como boa prática, recomenda-se que o commit seja feito **apenas** na branch nova criada, **nunca** no repositório *main*. As alterações na *main* devem ser realizadas via **Pull Request**.
2. Ao final da execução do `docker compose up`, o containeres estarão acessíveis na rede interna do computador: *localhost*.
- Acesso à aplicação PHP: [http://localhost](http://localhost)
- Acesso ao PHPMyAdmin: [http://localhost:8080](http://localhost:8080)
- Acesso direto ao MariaDB (por aplicação própria): [http://localhost:3306](http://localhost:3306)

## Prova de conceito do dashboard
- feito com python, necessita de instalação das bibliotecas apontadas em requirements.txt
- executar no terminal o comando streamlit run dash.py e abrir navegador com [(http://localhost:8501)](http://localhost:8501)
