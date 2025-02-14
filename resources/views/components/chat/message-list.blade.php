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
