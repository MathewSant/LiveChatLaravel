<!-- resources/views/livewire/chat.blade.php -->

<div class="flex h-[90vh]">
    <!-- Sidebar: Lista de usuários -->
    <div class="w-1/4 bg-gray-200 p-4 overflow-y-auto">
        @include('components.chat.user-list', [
            'users' => $users,
            'selectedUser' => $selectedUser
        ])
    </div>

    <!-- Área do Chat -->
    <div class="flex-1 bg-white shadow-lg rounded-lg flex flex-col">
        {{-- Cabeçalho do chat (pode exibir nome do destinatário, se houver) --}}
        @include('components.chat.header', [
            'user' => auth()->user(),
            'selectedUser' => $selectedUser
        ])

        {{-- Indicador de digitando --}}
        @include('components.chat.typing-indicator', [
            'currentUser' => auth()->user()->name
        ])

        {{-- Lista de mensagens --}}
        @include('components.chat.message-list', [
            'messages' => $messages
        ])

        {{-- Rodapé do chat --}}
        @include('components.chat.footer', [
            'attachment' => $attachment
        ])
    </div>
</div>
