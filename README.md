# Sistema de Gerenciamento de Tarefas

## 🚀 Objetivo

Desenvolver um sistema de gerenciamento de tarefas que permita aos usuários criar, atualizar e excluir tarefas. As tarefas devem poder ser categorizadas.

## ✔️ Tecnologias utilizadas
    Composer: Gerenciador de dependências para PHP.
    Node.js: Plataforma para execução de JavaScript no servidor.
    PHP: Linguagem de programação para desenvolvimento do backend.
    MySQL: Banco de dados relacional para armazenar informações.
    
## 🔍 Requisitos Funcionais

1. **Gerenciamento de Tarefas:**
    - Usuários devem poder criar, visualizar, atualizar e excluir tarefas.

2. **Categorização e Filtragem de Tarefas:**
    - As tarefas devem ser categorizáveis, e os usuários podem filtrar as tarefas por nome e categoria.
    - Cada tarefa deve pertencer a uma categoria.

3. **Ordenação:**
    - As tarefas podem ser ordenadas por nome em ordem crescente ou decrescente.

4. **Validação e Feedback:**
    - Implementado validação nos formulários para garantir a integridade dos dados.
    - Feedback visual claro ao usuário, incluindo mensagens de erro e sucesso para orientar e informar sobre a operação realizada.

## 🌟 Funcionalidades Adicionais

- **Filtragem:**
    - Filtre as tarefas por nome e categoria usando inputs de texto.

- **Ordenação:**
    - Ordene as tarefas por nome, alternando entre ordem crescente e decrescente ao clicar no cabeçalho da coluna.

## 🚀 Como Começar

1. 📁 **Clone o Repositório:**
    ```bash
    git clone https://github.com/dinailza09/task-management-system.git
    cd task-management-system
    ```

2. **Instale as Dependências:**
    ```bash
    composer install
    ```

3. **Configure o Ambiente:**
    - Renomeie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente conforme necessário.

4. **Execute as Migrations:**
    ```bash
    php artisan migrate
    ```

5. **Popule o Banco de Dados:**
    - Para criar dados iniciais no banco de dados, execute o comando:
    ```bash
    php artisan db:seed
    ```

6. **Inicie o Servidor de Desenvolvimento:**
    ```bash
    php artisan serve
    ```

7. 🛠️ **Rodar o Projeto**
    - Abra seu navegador e acesse `http://localhost:8000`.

