# 🚀 Gerador de Estrutura Modular para CodeIgniter 4

**Uma ferramenta CLI para gerar automaticamente módulos completos e
padronizados no CodeIgniter 4.**

<p align="center">
  <img src="https://img.shields.io/badge/PHP-%3E=8.1-777BB4?logo=php">
  <img src="https://img.shields.io/badge/CodeIgniter%204-Modular%20Generator-DD4814?logo=codeigniter">
  <img src="https://img.shields.io/badge/License-MIT-green">
</p>

## Sobre o Projeto

Este projeto adiciona ao CodeIgniter 4 um comando CLI chamado
`make:module`, que cria automaticamente toda a estrutura de um módulo
organizado --- incluindo Controllers, Models, Entities, Services,
Migrations, Routes e Views.

## Objetivo

Simplificar a criação de módulos padronizados, evitando repetição e
garantindo uma estrutura profissional desde o início.

## Instalação

### 1. Clonar o repositório

``` bash
git clone https://github.com/{seu-usuário}/gerador-modulos-ci4.git
```

### 2. Instalar dependências

``` bash
composer install
```

### 3. Registrar o comando no seu projeto CodeIgniter 4

Adicione no `composer.json`:

``` json
"autoload": {
    "psr-4": {
        "App\": "app/",
        "App\Commands\": "app/Commands"
    }
}
```

Depois:

``` bash
composer dump-autoload
```

## Como usar

``` bash
php spark make:module Users
```

Estrutura gerada:

    app/
    └── Modules/
        └── Users/
            ├── Config/
            │   └── Routes.php
            ├── Controllers/
            │   └── UsersController.php
            ├── Models/
            │   └── UsersModel.php
            ├── Entities/
            │   └── User.php
            ├── Database/
            │   └── Migrations/
            │       └── 2025-xx-xx-000001_create_users_table.php
            ├── Services/
            │   └── UserService.php
            └── Views/
                └── index.php

## Estrutura Criada

  Pasta                      Função
  -------------------------- ------------------------------------
  **Config/**                Arquivo de rotas do módulo
  **Controllers/**           Controladores principais do módulo
  **Models/**                Models para banco
  **Entities/**              Entidades de dados
  **Database/Migrations/**   Migration inicial do módulo
  **Services/**              Regras de negócio
  **Views/**                 Arquivos de interface

## Contribuições

Pull Requests são bem-vindos!

## 📄 Licença

Licença **MIT**.
