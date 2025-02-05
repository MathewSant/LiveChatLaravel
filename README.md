Chat em Tempo Real
==================

Este projeto é um sistema de chat em tempo real desenvolvido em **Laravel** utilizando **Livewire**, **Laravel Echo** e um servidor de broadcasting (Reverb, compatível com Pusher).

Pré-requisitos
--------------

*   PHP 8.3 (ou superior) com as extensões necessárias
*   Composer
*   Node.js e NPM
*   Banco de dados (MySQL, etc.)

Instalação
----------

1.  **Clone o repositório:**
    
        git clone https://github.com/MathewSant/LiveChatLaravel
    
2.  **Entre no diretório do projeto:**
    
        cd seu-repositorio
    
3.  **Instale as dependências do Composer:**
    
        composer install
    
4.  **Instale as dependências do NPM:**
    
        npm install
    
5.  **Crie uma cópia do arquivo `.env.example` como `.env`:**
    
        cp .env.example .env
    
6.  **Gere a chave da aplicação:**
    
        php artisan key:generate
    
7.  **Configure o arquivo `.env`** conforme seu ambiente. Um exemplo de configuração:
    
        APP_NAME=Laravel
        APP_ENV=local
        APP_KEY=base64:...
        APP_DEBUG=true
        APP_URL=http://localhost
        
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=chat_app
        DB_USERNAME=root
        DB_PASSWORD=
        
        BROADCAST_DRIVER=reverb
        REVERB_APP_ID=600751
        REVERB_APP_KEY=atf08xobqovoyb4numsu
        REVERB_APP_SECRET=u7ja88wyahuj4jncr2uk
        REVERB_HOST=127.0.0.1
        REVERB_PORT=6001
        REVERB_SCHEME=http
        
        VITE_REVERB_APP_KEY="atf08xobqovoyb4numsu"
        VITE_REVERB_HOST="127.0.0.1"
        VITE_REVERB_PORT="6001"
        VITE_REVERB_SCHEME="http"
        
        VITE_PUSHER_APP_CLUSTER=mt1
    

Configuração do Servidor de Broadcasting
----------------------------------------

Este projeto utiliza o **Reverb** (um servidor compatível com Pusher) para o broadcast em tempo real. Certifique-se de que o servidor esteja rodando e configurado para ouvir na porta definida (por exemplo, `6001`).

Compilação dos Assets
---------------------

1.  Para desenvolvimento:
    
        npm run dev
    
2.  Para produção:
    
        npm run build
    

Utilização
----------

O sistema de chat é acessado através da rota `/chat` no seu navegador.

*   Ao acessar a rota, você verá a interface do chat.
*   Digite seu nome e mensagem e clique em **Enviar**.
*   As mensagens serão salvas no banco de dados e transmitidas em tempo real para todas as abas conectadas.

Estrutura do Projeto
--------------------

*   `resources/js/app.js` - Ponto de entrada dos scripts do front-end.
*   `resources/js/echo.js` - Configuração do Laravel Echo.
*   `resources/js/bootstrap.js` - Configuração inicial (incluindo a importação do Pusher).
*   `resources/views/livewire/chat.blade.php` - View do componente Livewire do chat.
*   `app/Livewire/Chat.php` - Lógica do componente Livewire para o chat.
*   `app/Events/MessageSent.php` - Evento broadcast para mensagens enviadas.
*   `app/Http/Controllers/MessageController.php` - Endpoints para listar e (caso necessário) armazenar mensagens via API.
*   `vite.config.js` - Configuração do Vite.

Uso do Laravel Echo e Livewire
------------------------------

O sistema utiliza **Laravel Echo** para ouvir eventos de broadcast e **Livewire** para atualizar dinamicamente a interface do chat. Confira os principais pontos:

*   Ao enviar uma mensagem, o componente Livewire cria a mensagem no banco e dispara o evento `MessageSent`.
*   O Laravel Echo está configurado para escutar o canal `chat` e, ao receber o evento, emite um evento Livewire (`messageReceived`) para atualizar a interface.
*   O componente Livewire possui um listener para o evento `messageReceived` que aciona a atualização das mensagens.

Depuração e Problemas Conhecidos
--------------------------------

*   Se as mensagens não aparecem em tempo real, verifique:
    *   Se o Laravel Echo está devidamente configurado e conectado (verifique o console do navegador).
    *   Se o evento `MessageSent` está sendo disparado (utilize logs no servidor, se necessário).
    *   Se o listener do Livewire (`messageReceived`) está registrado e acionando o método correto para recarregar as mensagens.
*   Para problemas com CSRF em chamadas HTTP internas, considere desabilitar a verificação para rotas específicas ou enviar o token CSRF.
*   Certifique-se de que as variáveis de ambiente estão sendo carregadas corretamente (lembre-se do prefixo `VITE_` para variáveis usadas pelo Vite).

Contribuição
------------

Sinta-se à vontade para abrir issues ou enviar pull requests com melhorias e correções.


* * *

Desenvolvido por Mateus Santiago- [GitHub](https://github.com/MathewSant)