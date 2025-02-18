<div id="chat-box" class="flex-1 p-4 overflow-y-auto bg-gray-50" aria-live="polite">
    @if(!empty($messages) && is_array($messages))
        @php $previousUser = null; @endphp
        @foreach($messages as $msg)
            @php
                $isFirstInGroup = ($previousUser !== $msg['user_id']);
                $previousUser = $msg['user_id'];
            @endphp

            <x-chat.message 
                :message="$msg" 
                :isPrivateChat="$isPrivateChat" 
                :isFirstInGroup="$isFirstInGroup" />
        @endforeach
    @else
        <p class="text-gray-500">Nenhuma mensagem disponível.</p>
    @endif
</div>
