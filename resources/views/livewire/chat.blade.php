<div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden flex flex-col h-[90vh]">
  <!-- Header -->
  <header class="bg-blue-600 text-white text-center py-4">
    <h1 class="text-xl font-bold">Chat em Tempo Real</h1>
    <p class="text-sm">Bem-vindo, {{ auth()->user()->name }}</p>
  </header>

  <!-- Indicador de digitando -->
  <div id="typing-indicator" class="px-4 py-2 text-gray-600" style="display: none;"></div>
  
  <!-- Área de mensagens -->
  <div id="chat-box" class="flex-1 p-4 overflow-y-auto bg-gray-50" aria-live="polite">
    @if(!empty($messages) && is_array($messages))
      @foreach($messages as $msg)
        <div class="mb-2 p-2 rounded-md hover:bg-gray-100 transition duration-200">
          <span class="font-semibold text-blue-600">{{ $msg['name'] }}:</span>
          <span>{{ $msg['message'] }}</span>
        </div>
      @endforeach
    @else
      <p class="text-gray-500">Nenhuma mensagem disponível.</p>
    @endif
  </div>

  <!-- Footer -->
  <footer class="border-t bg-white p-4 relative">
    <div class="flex">
        <input 
            type="text" 
            wire:model.defer="message" 
            id="chat-input"
            wire:keydown.debounce.500ms="emitTyping"
            placeholder="Escreva sua mensagem" 
            class="w-full px-3 py-2 me-1 border rounded-l focus:outline-none focus:ring focus:border-blue-300"
            aria-label="Mensagem"
        >
        <button 
            id="emoji-button" 
            class="bg-gray-200 px-2 border border-gray-300 rounded-l focus:outline-none">
            😊
        </button>
        <button 
            wire:click="sendMessage" 
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-r focus:outline-none focus:ring">
            Enviar
        </button>
    </div>
</footer>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function subscribeToChat() {
        window.Echo.channel('chat')
            .listen('.MessageSent', (e) => {
                if (window.Livewire) {
                    Livewire.dispatch('messageReceived', e.message);
                }
            })
            .listen('.UserTyping', (e) => {
                if (e.name !== "{{ auth()->user()->name }}") {
                    const typingIndicator = document.getElementById('typing-indicator');
                    typingIndicator.innerText = e.name + " está digitando...";
                    typingIndicator.style.display = "block";
                    
                    setTimeout(() => {
                        typingIndicator.style.display = "none";
                    }, 3000);
                }
            });
    }

    if (window.Livewire && window.Livewire.hook) {
        subscribeToChat();
    } else {
        document.addEventListener("livewire:load", function () {
            subscribeToChat();
        });
    }
});

document.addEventListener('livewire:update', () => {
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
});

</script>