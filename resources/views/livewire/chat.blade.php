<div>
    <h2 class="text-lg font-bold">Chat em Tempo Real</h2>
    
    <div class="border p-4 h-64 overflow-y-auto" id="chat-box">
        @if(!empty($messages) && is_array($messages))
            @foreach($messages as $msg)
                @if(is_array($msg) && isset($msg['name']) && isset($msg['message']))
                    <div class="mb-2">
                        <strong>{{ $msg['name'] }}</strong>: {{ $msg['message'] }}
                    </div>
                @endif
            @endforeach
        @else
            <p>Nenhuma mensagem disponível.</p>
        @endif
    </div>
    
    <input type="text" wire:model="name" placeholder="Seu Nome" class="border p-2 w-full">
    <input type="text" wire:model="message" placeholder="Escreva sua mensagem" class="border p-2 w-full mt-2">
    
    <button wire:click="sendMessage" class="btn btn-primary">Enviar</button>

    <script>

    document.addEventListener("DOMContentLoaded", function () {
        console.log(window.Echo);

        if (typeof window.Echo === 'undefined') {
            console.error("Laravel Echo não foi carregado corretamente.");
            return;
        }

        window.Echo.channel('chat')
            .listen('MessageSent', (e) => {
                console.log("Mensagem recebida:", e.message);
                // Emite um evento Livewire para que o componente atualize suas mensagens
                Livewire.emit('messageReceived', e.message);
            });
    });

    </script>
    
    
</div>
