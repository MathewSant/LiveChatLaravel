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

                  @if (!empty($msg['attachment']))
                      <div class="mt-1">
                          <a href="{{ asset('storage/' . $msg['attachment']) }}" target="_blank" class="text-blue-500 hover:underline flex items-center">
                              @svg('bi-paperclip', 'w-5 h-5 text-blue-400 me-1')
                              <span>Baixar Anexo</span>
                          </a>
                      </div>
                  @endif
              </div>
          @endforeach
      @else
          <p class="text-gray-500">Nenhuma mensagem disponível.</p>
      @endif
  </div>

    <!-- Footer -->
    <footer class="border-t bg-white p-4 relative">
      <div class="flex items-center space-x-2">
          <!-- Campo de texto -->
          <input 
              type="text" 
              wire:model.defer="message" 
              id="chat-input"
              wire:keydown.debounce.500ms="emitTyping"
              placeholder="Escreva sua mensagem..." 
              class="w-full px-3 py-2 border rounded-l focus:outline-none focus:ring focus:border-blue-300"
          >
          
          <!-- Botão de Emoji -->
          <button id="emoji-button" class="bg-gray-200 p-2 border border-gray-300 rounded focus:outline-none">
              @svg('bi-emoji-smile', 'w-6 h-6 text-gray-600 hover:text-blue-500')
          </button>

          <!-- Botão de Anexo -->
          <label for="file-upload" class="cursor-pointer bg-gray-200 p-2 border border-gray-300 rounded hover:bg-gray-300 transition">
              @svg('bi-paperclip', 'w-6 h-6 text-gray-600 hover:text-blue-500')
          </label>
          <input 
              type="file" 
              id="file-upload" 
              wire:model="attachment" 
              class="hidden"
          >

          <!-- Botão de Enviar -->
          <button 
              wire:click="sendMessage" 
              class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-r focus:outline-none focus:ring flex items-center">
              @svg('bi-send', 'w-6 h-6 text-white')
          </button>
      </div>

      <!-- Exibição do Arquivo Selecionado -->
      @if ($attachment)
      <div class="mt-2 flex items-center space-x-2">
          <p class="text-sm text-gray-600 flex items-center">
              @svg('bi-file-earmark', 'w-5 h-5 text-gray-600 me-1')
              {{ $attachment->getClientOriginalName() }}
          </p>
          <button wire:click="$set('attachment', null)" class="p-1 text-red-500 hover:text-red-700">
              @svg('bi-x-circle', 'w-5 h-5')
          </button>
      </div>
      @endif
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
      
      Livewire.on('clearChatInput', () => {
          const chatInput = document.getElementById('chat-input');
          if (chatInput) {
              chatInput.value = '';
              chatInput.focus();
          }
      });
  });
  
  document.addEventListener('livewire:update', () => {
      const chatBox = document.getElementById('chat-box');
      chatBox.scrollTop = chatBox.scrollHeight;
  });
  
  window.addEventListener('clearChatInput', event => {
      const chatInput = document.getElementById('chat-input');
      chatInput.value = '';
      chatInput.focus();
  });
  </script>