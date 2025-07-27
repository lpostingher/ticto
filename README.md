# Sistema de Controle de Ponto Eletrônico

Este projeto, desenvolvido em Laravel, tem como objetivo realizar o controle de ponto eletrônico, registrando entradas e saídas dos funcionários.

Também inclui funcionalidades como o cadastro completo de usuários e a geração de relatórios de registros.

## Requisitos

- PHP 8.4  
- Node.js 22.17.1  
- MySQL 8.0  
- Docker (para uso com Laravel Sail)

## Instalação

Siga os passos abaixo para instalar e executar o projeto em sua máquina local.

### 1. Clone do repositório

Abra o terminal, acesse o diretório desejado e execute:

```bash
git clone https://github.com/lpostingher/ticto.git
```

### 2. Instalação das dependências PHP

Dentro da pasta do projeto, instale as dependências com o Composer:

```bash
composer install
```

### 3. Instalação e build dos pacotes Node.js

```bash
npm install && npm run build
```

### 4. Subindo os containers com Laravel Sail

Certifique-se de que o Docker esteja instalado e em execução. Em seguida, inicie os containers:

```bash
./vendor/bin/sail up -d
```

> **Obs.:** Ao utilizar o Laravel Sail, todos os comandos `artisan` devem ser precedidos por `./vendor/bin/sail`, como em `./vendor/bin/sail artisan migrate`.

### 5. Configuração do ambiente

- Renomeie o arquivo `.env.example` para `.env`.
- Atualize os parâmetros de configuração do banco de dados conforme o seu ambiente (recomenda-se MySQL com engine InnoDB).

### 6. Geração da chave da aplicação

Execute:

```bash
php artisan key:generate
```

### 7. Migração e seed do banco de dados

Execute as migrações para criar as tabelas:

```bash
php artisan migrate
```

Em seguida, execute o seed para preencher dados iniciais (países, estados, cidades e um usuário administrador):

```bash
php artisan db:seed
```

> **Usuário administrador inicial:**  
> - **E-mail:** `admin@example.com`  
> - **Senha:** `password`

---

## Testes Automatizados

O projeto conta com testes unitários para garantir a qualidade das funcionalidades implementadas.

Para rodar os testes, utilize:

```bash
php artisan test
```

---

## Análise de Qualidade de Código

O projeto utiliza ferramentas de análise de qualidade para manter o código limpo e padronizado.

### PHP Code Sniffer

Executa a análise de padrões de codificação definidos:

```bash
vendor/bin/phpcs -p
```

Corrige automaticamente problemas detectados:

```bash
vendor/bin/phpcbf -p
```

### PHP Insights

Verifica aspectos como arquitetura, complexidade e estilo de código, atribuindo uma pontuação com base nos parâmetros configurados:

```bash
php artisan insights
```
