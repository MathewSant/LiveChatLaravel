<footer class="border-t bg-white p-4 relative">
    <div class="flex items-center space-x-2">
        {{-- Campo de texto --}}
        <input 
            type="text" 
            wire:model.defer="message" 
            id="chat-input"
            wire:keydown.debounce.500ms="emitTyping"
            placeholder="Escreva sua mensagem..." 
            class="w-full px-3 py-2 border rounded-l focus:outline-none focus:ring focus:border-blue-300"
        >

        {{-- Botão de Emoji --}}
        <button id="emoji-button" class="bg-gray-200 p-2 border border-gray-300 rounded focus:outline-none">
            @svg('bi-emoji-smile', 'w-6 h-6 text-gray-600 hover:text-blue-500')
        </button>

        {{-- Botão de Anexo --}}
        <label for="file-upload" class="cursor-pointer bg-gray-200 p-2 border border-gray-300 rounded hover:bg-gray-300 transition">
            @svg('bi-paperclip', 'w-6 h-6 text-gray-600 hover:text-blue-500')
        </label>
        <input 
            type="file" 
            id="file-upload" 
            wire:model="attachment" 
            class="hidden"
        >

        {{-- Botão de Enviar --}}
        <button 
            wire:click="sendMessage" 
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-r focus:outline-none focus:ring flex items-center">
            @svg('bi-send', 'w-6 h-6 text-white')
        </button>
    </div>

    {{-- Exibição do Arquivo Selecionado --}}
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
