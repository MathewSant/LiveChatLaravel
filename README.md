<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat em Tempo Real - Projeto Laravel com Livewire e Echo</title>
  <style>
    body { 
      font-family: Arial, sans-serif; 
      line-height: 1.6; 
      margin: 0; 
      padding: 0; 
      background-color: #f9f9f9;
    }
    .container { 
      padding: 20px; 
      max-width: 800px; 
      margin: 20px auto; 
      background-color: #fff; 
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1, h2, h3 { color: #333; }
    pre { 
      background: #f4f4f4; 
      padding: 10px; 
      overflow-x: auto; 
    }
    code { 
      background: #f4f4f4; 
      padding: 3px 5px; 
      border-radius: 3px;
    }
    ul, ol { margin-left: 20px; }
    a { color: #007BFF; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Chat em Tempo Real</h1>
    <p>Este projeto é um sistema de chat em tempo real desenvolvido em <strong>Laravel</strong> utilizando <strong>Livewire</strong>, <strong>Laravel Echo</strong> e um servidor de broadcasting (Reverb, compatível com Pusher).</p>

    <h2>Pré-requisitos</h2>
    <ul>
      <li>PHP 8.3 (ou superior) com as extensões necessárias</li>
      <li>Composer</li>
      <li>Node.js e NPM</li>
      <li>Banco de dados (MySQL, etc.)</li>
    </ul>

    <h2>Instalação</h2>
    <ol>
      <li>
        <strong>Clone o repositório:</strong>
        <pre><code>git clone https://github.com/seu-usuario/seu-repositorio.git</code></pre>
      </li>
      <li>
        <strong>Entre no diretório do projeto:</strong>
        <pre><code>cd seu-repositorio</code></pre>
      </li>
      <li>
        <strong>Instale as dependências do Composer:</strong>
        <pre><code>composer install</code></pre>
      </li>
      <li>
        <strong>Instale as dependências do NPM:</strong>
        <pre><code>npm install</code></pre>
      </li>
      <li>
        <strong>Crie uma cópia do arquivo <code>.env.example</code> como <code>.env</code>:</strong>
        <pre><code>cp .env.example .env</code></pre>
      </li>
      <li>
        <strong>Gere a chave da aplicação:</strong>
        <pre><code>php artisan key:generate</code></pre>
      </li>
      <li>
        <strong>Configure o arquivo <code>.env</code></strong> conforme seu ambiente. Um exemplo de configuração:
        <pre><code>APP_NAME=Laravel
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

VITE_PUSHER_APP_CLUSTER=mt1</code></pre>
      </li>
    </ol>

    <h2>Configuração do Servidor de Broadcasting</h2>
    <p>Este projeto utiliza o <strong>Reverb</strong> (um servidor compatível com Pusher) para o broadcast em tempo real. Certifique-se de que o servidor esteja rodando e configurado para ouvir na porta definida (por exemplo, <code>6001</code>).</p>

    <h2>Compilação dos Assets</h2>
    <ol>
      <li>
        Para desenvolvimento:
        <pre><code>npm run dev</code></pre>
      </li>
      <li>
        Para produção:
        <pre><code>npm run build</code></pre>
      </li>
    </ol>

    <h2>Utilização</h2>
    <p>O sistema de chat é acessado através da rota <code>/chat</code> no seu navegador.</p>
    <ul>
      <li>Ao acessar a rota, você verá a interface do chat.</li>
      <li>Digite seu nome e mensagem e clique em <strong>Enviar</strong>.</li>
      <li>As mensagens serão salvas no banco de dados e transmitidas em tempo real para todas as abas conectadas.</li>
    </ul>

    <h2>Estrutura do Projeto</h2>
    <ul>
      <li><code>resources/js/app.js</code> - Ponto de entrada dos scripts do front-end.</li>
      <li><code>resources/js/echo.js</code> - Configuração do Laravel Echo.</li>
      <li><code>resources/js/bootstrap.js</code> - Configuração inicial (incluindo a importação do Pusher).</li>
      <li><code>resources/views/livewire/chat.blade.php</code> - View do componente Livewire do chat.</li>
      <li><code>app/Livewire/Chat.php</code> - Lógica do componente Livewire para o chat.</li>
      <li><code>app/Events/MessageSent.php</code> - Evento broadcast para mensagens enviadas.</li>
      <li><code>app/Http/Controllers/MessageController.php</code> - Endpoints para listar e (caso necessário) armazenar mensagens via API.</li>
      <li><code>vite.config.js</code> - Configuração do Vite.</li>
    </ul>

    <h2>Uso do Laravel Echo e Livewire</h2>
    <p>O sistema utiliza <strong>Laravel Echo</strong> para ouvir eventos de broadcast e <strong>Livewire</strong> para atualizar dinamicamente a interface do chat. Confira os principais pontos:</p>
    <ul>
      <li>Ao enviar uma mensagem, o componente Livewire cria a mensagem no banco e dispara o evento <code>MessageSent</code>.</li>
      <li>O Laravel Echo está configurado para escutar o canal <code>chat</code> e, ao receber o evento, emite um evento Livewire (<code>messageReceived</code>) para atualizar a interface.</li>
      <li>O componente Livewire possui um listener para o evento <code>messageReceived</code> que aciona a atualização das mensagens.</li>
    </ul>

    <h2>Depuração e Problemas Conhecidos</h2>
    <ul>
      <li>
        Se as mensagens não aparecem em tempo real, verifique:
        <ul>
          <li>Se o Laravel Echo está devidamente configurado e conectado (verifique o console do navegador).</li>
          <li>Se o evento <code>MessageSent</code> está sendo disparado (utilize logs no servidor, se necessário).</li>
          <li>Se o listener do Livewire (<code>messageReceived</code>) está registrado e acionando o método correto para recarregar as mensagens.</li>
        </ul>
      </li>
      <li>Para problemas com CSRF em chamadas HTTP internas, considere desabilitar a verificação para rotas específicas ou enviar o token CSRF.</li>
      <li>Certifique-se de que as variáveis de ambiente estão sendo carregadas corretamente (lembre-se do prefixo <code>VITE_</code> para variáveis usadas pelo Vite).</li>
    </ul>

    <h2>Contribuição</h2>
    <p>Sinta-se à vontade para abrir issues ou enviar pull requests com melhorias e correções.</p>

    <h2>Licença</h2>

    <hr>
    <p>Desenvolvido por Mateus Santiago- <a href="https://github.com/MathewSant" target="_blank">GitHub</a></p>
  </div>
</body>
</html>
