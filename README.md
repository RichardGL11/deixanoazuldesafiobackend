![Logo Deixa no Azul](https://github.com/deixanoazul/desafio-backend/blob/main/DNA.png "Deixa no Azul")

# Desafio Back-End - Deixa no Azul

Esse desafio é destinado á todos os níveis e não é exigido que você consiga realizar esse desafio por completo.

Sua avaliação será dada pelas fases que conseguir entregar e a forma com que foram desenvolvidas.

## Pré-requisitos

- Lógica de programação;
- Conhecimentos sobre Banco de dados;
- Conhecimentos sobre HTTP, API e REST ;
- Conhecimentos sobre Git;

## Requisitos do desafio

- Utilizar PHP(7), caso se sinta confortável, utilize o Láravel
- O código deve seguir o padrão PSR4;
- Adicionar no README instruções de como executar o projeto.
- A API deve receber e retornar dados no formato JSON.
- Documentas as rotas.

## Diferenciais

- Utilizar o Laravel(7.4)
- Código limpo
- Criar o fork no início do desenvolvimento e realizar commits de acordo com a conclusão das fases.


Caso não consiga fazer todas as fases do desafio tudo bem


### Fase 1 - Usuários
Nesta fase serão implementados os usuários do sistema e seus endpoints:

- Criar um endpoint onde é cadastrado um usuário.
    - Esses usuários devem ter obrigátoriamente os seguintes dados modelados, caso você ache necessário outros campos fique a vontade.
        - **name** | string (Nome)
        - **email** | string (E-mail)
        - **birthday** | date (Data de aniversário)
        - **cpf** | string
        - **created_at** | datetime (Criado Em)
        - **updated_at** | datetime (Atualizado Em)
- Criar um endpoint para listagem desses usuários, ordernados por ordem de cadastro decrescente (mais novo para mais antigo);
- Criar um endpoint para listar um único usuário através do seu id;
- Criar um endpoint para excluir um usuário através do seu id.

### Fase 2 - Transação
Nesta fase serão implementados as Transações e seus respectivos endpoints:

- Criar um endpoint ou endpoints onde é possível associar uma operação de débito, crédito ou estorno para o usuário;
- Criar um endpoint onde seja possível visualizar todas as transações (páginada) dos usuários mais as suas informações pessoais;
- Criar um endpoint onde seja possível excluir uma transação relacionada a um usuário.


### Fase 3 - Novas Funcionalidades
Nessa fase serão implementadas novas funcionalidades no sistema:

- Adicionar dentro do usuário um campo para saldo inicial, e criar um endpoint para alterar esse valor;
- Criar um endpoint com a soma de todas as transações (débito, crédito e estorno);
- No endpoint que exclui um usuário, adicionar a funcionalidade que agora não será mais possível excluir um usuário que tenha qualquer tipo de transação associada ou saldo;
- No endpoint que cadastra usuário, adicionar a funcionalidade que apenas maiores de 21 anos podem criar uma conta.

### Fase 4 -Itens Não Obrigatórios
- Criar validações com base na Request;
- Implementar ao menos uma camada entre o controller e o model
- Utilizar cache para otimizar as consultas e buscas;
- Criar Seeders ou Inicializadores de dados para o usuários e suas Transações;
- Criar os métodos baseados em algum método de autenticação;
- Documentação dos endpoints;
- Utilizar commits de acordo com cada fase do desenvolvimento.

## Ao Concluir
Crie um fork e submeta uma pull request ao GitHub com o seu desafio. Após isso envie um e-mail para 'matheus.morais@deixanoazul.com.br', com o assunto 'DESAFIO BACK-END' e currículo em anexo.
