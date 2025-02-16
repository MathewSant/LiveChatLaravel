<!-- resources/views/components/chat/header.blade.php -->

<div class="p-4 bg-blue-500 text-white flex items-center justify-between">
    <div>
        <h1 class="text-lg font-bold">
            @if(isset($selectedUser))
                Conversa com {{ $selectedUser->name }}
            @else
                Chat Público
            @endif
        </h1>
    </div>
    <!-- Outras opções, se necessário -->
</div>
