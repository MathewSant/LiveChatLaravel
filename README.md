Chat em Tempo Real
====================================

Este projeto é um sistema de chat em tempo real desenvolvido em **Laravel** utilizando **Livewire**, **Laravel Echo** e o servidor de broadcasting **Reverb** (compatível com Pusher). Ele permite conversas públicas e privadas, envio de anexos e atualizações instantâneas na interface, proporcionando uma experiência interativa e moderna.

Requisitos
----------

*   PHP 8.3 (ou superior) com as extensões necessárias
*   Composer
*   Node.js e NPM
*   Banco de dados (MySQL, etc.)

Instalação
----------

1.  **Clone o repositório:**
    
    git clone https://github.com/MathewSant/LiveChatLaravel
    
2.  **Entre no diretório do projeto:**
    
    cd LiveChatLaravel
    
3.  **Instale as dependências do Composer:**
    
    composer install
    
4.  **Instale as dependências do NPM:**
    
    npm install
    
5.  **Crie uma cópia do arquivo `.env.example` como `.env`:**
    
    cp .env.example .env
    
6.  **Gere a chave da aplicação:**
    
    php artisan key:generate
    
7.  **Configure o arquivo `.env`** conforme seu ambiente. Exemplo de configuração:
    
    APP\_NAME=Laravel
    APP\_ENV=local
    APP\_KEY=base64:jeh3Y/XmIn2e01C7cp8FhPiJQsmEBhTn/Aceo5QnN7g=
    APP\_DEBUG=true
    APP\_TIMEZONE=America/Sao\_Paulo
    APP\_URL=http://localhost
    
    APP\_LOCALE=en
    APP\_FALLBACK\_LOCALE=en
    APP\_FAKER\_LOCALE=en\_US
    
    DB\_CONNECTION=mysql
    DB\_HOST=127.0.0.1
    DB\_PORT=3306
    DB\_DATABASE=chat\_app
    DB\_USERNAME=root
    DB\_PASSWORD=root
    
    SESSION\_DRIVER=database
    SESSION\_LIFETIME=120
    
    BROADCAST\_DRIVER=reverb
    REVERB\_APP\_ID=600751
    REVERB\_APP\_KEY=atf08xobqovoyb4numsu
    REVERB\_APP\_SECRET=u7ja88wyahuj4jncr2uk
    REVERB\_HOST=127.0.0.1
    REVERB\_PORT=6001
    REVERB\_SCHEME=http
    
    VITE\_REVERB\_APP\_KEY="atf08xobqovoyb4numsu"
    VITE\_REVERB\_HOST="127.0.0.1"
    VITE\_REVERB\_PORT="6001"
    VITE\_REVERB\_SCHEME="http"
    VITE\_PUSHER\_APP\_CLUSTER=mt1
    
    MAIL\_MAILER=log
          
    
    Atualize as variáveis conforme necessário, especialmente as configurações de banco de dados e broadcasting.
    

Configuração do Servidor de Broadcasting
----------------------------------------

O sistema utiliza o **Reverb** para broadcast em tempo real. Certifique-se de que o servidor esteja rodando e configurado para escutar na porta definida (por exemplo, `6001`).

Compilação dos Assets
---------------------

1.  **Para desenvolvimento:**
    
    npm run dev
    
2.  **Para produção:**
    
    npm run build
    

Utilização
----------

Acesse o sistema pelo navegador através da rota `/chat`. Na interface do chat, você poderá:

*   Visualizar conversas públicas e privadas
*   Selecionar usuários para iniciar conversas privadas
*   Enviar mensagens de texto e anexos
*   Acompanhar atualizações em tempo real

Estrutura do Projeto
--------------------

*   `.env` – Arquivo de configuração do ambiente
*   `app/Livewire/Chat/Chat.php` – Componente Livewire que gerencia a lógica do chat (envio, recebimento e exibição de mensagens)
*   `app/Models/Message.php` – Modelo de mensagem com ID gerado via _Snowflake_
*   `app/Models/User.php` – Modelo de usuário
*   `app/Repositories/Chat/MessageRepository.php` – Repositório para consulta e manipulação de mensagens
*   `app/Services/Chat/ChatService.php` – Serviço que gerencia o envio de mensagens e a emissão de eventos (como `MessageSent` e `UserTyping`)
*   `resources/views/livewire/chat.blade.php` – View principal do chat, que inclui os componentes:
    *   `components/chat/header.blade.php` – Cabeçalho do chat
    *   `components/chat/footer.blade.php` – Rodapé com entrada de mensagens e anexos
    *   `components/chat/message-list.blade.php` – Lista de mensagens
    *   `components/chat/typing-indicator.blade.php` – Indicador de digitação
    *   `components/chat/user-list.blade.php` – Lista de usuários
*   `resources/js/app.js` – Ponto de entrada do JavaScript com integração do Alpine.js e funcionalidades do chat
*   `resources/js/echo.js` – Configuração do Laravel Echo para broadcast em tempo real
*   `vite.config.js` – Configuração do Vite para compilação dos assets

Como Funciona
-------------

### Livewire & Laravel Echo

O sistema utiliza **Livewire** para criar componentes dinâmicos e reativos. O componente `Chat` realiza:

*   Carregamento de mensagens públicas e privadas
*   Envio de mensagens (texto e anexos)
*   Seleção de usuários para conversas privadas
*   Emissão de eventos, como `MessageSent`, `UserTyping` e `UserStoppedTyping`

O **Laravel Echo** é configurado em `resources/js/echo.js` para escutar os canais de broadcast e atualizar a interface do chat em tempo real.

Depuração e Solução de Problemas
--------------------------------

*   **Mensagens não atualizam em tempo real:**
    *   Verifique se o Laravel Echo está corretamente configurado (consulte o console do navegador).
    *   Confirme se os eventos de broadcast (`MessageSent` etc.) estão sendo disparados corretamente no servidor.
    *   Certifique-se de que o servidor Reverb está ativo e configurado para a porta correta.
*   **Problemas com CSRF:**
    
    Em caso de problemas com o token CSRF, ajuste as rotas ou garanta que o token seja enviado adequadamente nas chamadas HTTP.
    
*   **Variáveis de Ambiente:**
    
    Verifique se todas as variáveis (especialmente as que iniciam com `VITE_`) estão corretamente configuradas no `.env`.
    

Contribuição
------------

Contribuições são sempre bem-vindas! Caso você encontre algum bug ou tenha sugestões de melhorias, abra uma issue ou envie um pull request.

* * *

Desenvolvido por **Mateus Santiago** – [GitHub](https://github.com/MathewSant)
