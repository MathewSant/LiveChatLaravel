@props([
    'message',         // Array com os dados da mensagem
    'isPrivateChat' => false,  // Boolean para indicar chat privado (não exibe avatar/nome no balão)
    'isFirstInGroup' => false, // Boolean para indicar se é a primeira mensagem consecutiva
])

@php
    $isOwnMessage = ($message['user_id'] == Auth::id());
@endphp

<div class="mb-2 flex {{ $isOwnMessage ? 'justify-end' : 'justify-start' }}">
    <div class="max-w-xs flex items-start">
        {{-- Se for mensagem do próprio usuário --}}
        @if($isOwnMessage)
            <div class="bg-blue-500 text-white p-2 rounded-lg rounded-br-none">
                @if(!$isPrivateChat && $isFirstInGroup)
                    <div class="text-sm font-semibold text-right">{{ $message['name'] }}</div>
                @endif
                <div class="text-sm">{{ $message['message'] }}</div>
                @if (!empty($message['attachment']))
                    <div class="mt-1">
                        <a href="{{ asset('storage/' . $message['attachment']) }}" target="_blank"
                           class="text-white underline flex items-center">
                            @svg('bi-paperclip', 'w-5 h-5 text-white me-1')
                            <span>Baixar Anexo</span>
                        </a>
                    </div>
                @endif
                <div class="text-xs text-right text-blue-100 mt-1">
                    {{ $message['created_at'] }}
                </div>
            </div>
            @if(!$isPrivateChat)
                @if($isFirstInGroup)
                    <div class="ml-2">
                        @if (!empty($message['profile_image']))
                            <img src="{{ asset('storage/' . $message['profile_image']) }}" 
                                 alt="{{ $message['name'] }}" 
                                 class="h-8 w-8 rounded-full object-cover">
                        @else
                            @svg('fas-user', 'h-8 w-8 text-gray-400')
                        @endif
                    </div>
                @else
                    <div class="ml-2" style="width: 32px;"></div>
                @endif
            @endif
        @else
            {{-- Mensagem de outro usuário --}}
            @if(!$isPrivateChat)
                @if($isFirstInGroup)
                    <div class="mr-2">
                        @if (!empty($message['profile_image']))
                            <img src="{{ asset('storage/' . $message['profile_image']) }}" 
                                 alt="{{ $message['name'] }}" 
                                 class="h-8 w-8 rounded-full object-cover">
                        @else
                            @svg('fas-user', 'h-8 w-8 text-gray-400')
                        @endif
                    </div>
                @else
                    <div class="mr-2" style="width: 32px;"></div>
                @endif
            @endif
            <div class="bg-gray-200 text-gray-800 p-2 rounded-lg rounded-bl-none">
                @if(!$isPrivateChat && $isFirstInGroup)
                    <div class="text-sm font-semibold">{{ $message['name'] }}</div>
                @endif
                <div class="text-sm">{{ $message['message'] }}</div>
                @if (!empty($message['attachment']))
                    <div class="mt-1">
                        <a href="{{ asset('storage/' . $message['attachment']) }}" target="_blank"
                           class="text-blue-500 hover:underline flex items-center">
                            @svg('bi-paperclip', 'w-5 h-5 text-blue-400 me-1')
                            <span>Baixar Anexo</span>
                        </a>
                    </div>
                @endif
                <div class="text-xs text-right text-gray-500 mt-1">
                    {{ $message['created_at'] }}
                </div>
            </div>
        @endif
    </div>
</div>
