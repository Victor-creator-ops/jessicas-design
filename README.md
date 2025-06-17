# JESSICA'S DESIGN - Sistema de Gestão de Projetos

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)

## 📖 Sobre o Projeto

**JESSICA'S DESIGN** é um sistema de gestão de projetos (SGP) web, sob medida, desenvolvido para atender às necessidades específicas de escritórios de design de interiores. A plataforma foi concebida para resolver as ineficiências operacionais geradas pelo uso de ferramentas genéricas, como planilhas e e-mails, para o controle de projetos complexos.

O sistema centraliza a comunicação, o versionamento de arquivos e o acompanhamento do ciclo de vida de cada projeto, proporcionando uma experiência premium e organizada tanto para a equipe interna quanto para o cliente final.

Este projeto foi desenvolvido como parte do Projeto Integrador do curso de Análise e Desenvolvimento de Sistemas da FATEC Indaiatuba.

---

## ✨ Funcionalidades Principais

A plataforma foi construída com base em um detalhado levantamento de requisitos, resultando nas seguintes funcionalidades:

-   **Painel de Controle Administrativo:** Uma visão macro para a gestão do negócio, com indicadores-chave como projetos ativos, valor total dos contratos e carga de trabalho da equipe (RF06).
-   **Gestão de Entidades:** Formulários completos para cadastro e gerenciamento de Clientes, Designers e Projetos (RF02).
-   **Kanban de Projetos Interativo:** Um quadro visual com as fases do projeto (Inspiração, Estudo Preliminar, etc.), com funcionalidade de arrastar e soltar (drag and drop) para atualizar o status dos projetos de forma intuitiva (RF03).
-   **Portal Exclusivo do Cliente:** Uma área restrita onde o cliente pode acompanhar o andamento do seu projeto, visualizar e baixar arquivos, e centralizar o feedback através de aprovações ou solicitações de alteração (RF04).
-   **Fluxo de Aprovação Versionado:** A equipe pode enviar novas versões de arquivos, e o cliente pode interagir com cada uma, mantendo um histórico claro de todas as iterações (RF05).
-   **Sistema de Notificações:** Envios automáticos de e-mail para eventos importantes, como o cadastro de um novo usuário ou o envio de um arquivo para revisão (RF07).
-   **Controle de Acesso por Papéis:** O sistema distingue 3 tipos de usuários (Administrador, Designer, Cliente), cada um com suas permissões e visões específicas, garantindo a segurança e a privacidade dos dados (RF01).

---

## 🛠️ Tecnologias Utilizadas

-   **Backend:** PHP 8.2+ / Laravel 11+
-   **Frontend:** Blade, Tailwind CSS, Alpine.js
-   **Banco de Dados:** MySQL
-   **Servidor de Desenvolvimento:** Vite
-   **Autenticação:** Laravel Breeze

---

## 🚀 Instruções para Rodar o Projeto Localmente

Para executar este projeto no seu ambiente de desenvolvimento, siga os passos abaixo.

### Pré-requisitos

-   PHP (versão 8.2 ou superior)
-   Composer
-   Node.js e NPM
-   Um servidor de banco de dados (ex: MySQL, MariaDB)

### Passo a Passo

1.  **Clone o Repositório:**

    ```bash
    git clone [https://github.com/Victor-creator-ops/jessicas-design.git](https://github.com/Victor-creator-ops/jessicas-design.git)
    cd jessicas-design
    ```

2.  **Instale as Dependências do PHP:**

    ```bash
    composer install
    ```

3.  **Instale as Dependências do JavaScript:**

    ```bash
    npm install
    ```

4.  **Configure o Ambiente:**
    Copie o arquivo de exemplo de ambiente.

    ```bash
    cp .env.example .env
    ```

    Abra o arquivo `.env` e configure as credenciais do seu banco de dados (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

5.  **Gere a Chave da Aplicação:**

    ```bash
    php artisan key:generate
    ```

6.  **Execute as Migrações e os Seeders:**
    Este comando irá criar todas as tabelas no banco de dados e popular com os dados iniciais (fases do projeto e a conta de administrador).

    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Inicie os Servidores de Desenvolvimento:**
    Você precisará de **dois terminais** rodando simultaneamente na pasta do projeto.

    -   **No primeiro terminal**, inicie o servidor do Vite para compilar os assets:
        ```bash
        npm run dev
        ```
    -   **No segundo terminal**, inicie o servidor do Laravel:
        ```bash
        php artisan serve
        ```

8.  **Acesse a Aplicação:**
    Abra o seu navegador e acesse o endereço fornecido pelo `php artisan serve` (geralmente **`http://127.0.0.1:8000`**).

---

## 🔑 Como Usar

O sistema possui um usuário administrador padrão criado pelo seeder para que você possa começar a usar a plataforma imediatamente.

-   **URL de Login:** `http://127.0.0.1:8000/login`
-   **Email do Administrador:** `jessica.diretora@email.com`
-   **Senha:** `password`

A partir do painel do administrador, você pode começar a cadastrar novos designers, clientes e projetos.

---

## 📊 Estrutura do Banco de Dados

O banco de dados foi modelado para refletir as entidades e relacionamentos do negócio.

![Diagrama Entidade-Relacionamento](caminho/para/sua/imagem-do-der.jpg)
Ainda vou colocar a imagem aqui.
