<div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden flex flex-col h-[90vh]">
    {{-- Cabeçalho do chat --}}
    @include('components.chat.header', ['user' => auth()->user()])

    {{-- Indicador de digitando --}}
    @include('components.chat.typing-indicator', ['currentUser' => auth()->user()->name])

    {{-- Lista de mensagens --}}
    @include('components.chat.message-list', ['messages' => $messages])

    {{-- Rodapé do chat --}}
    @include('components.chat.footer', ['attachment' => $attachment])
</div>
