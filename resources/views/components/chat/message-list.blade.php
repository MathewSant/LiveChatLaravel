<div id="chat-box" class="flex-1 p-4 overflow-y-auto bg-gray-50" aria-live="polite">
    @if(!empty($messages) && is_array($messages))
        @php $previousUser = null; @endphp

        @foreach($messages as $msg)
            @php
                // Verifica se é a primeira mensagem consecutiva desse user_id
                $showHeader = ($previousUser !== $msg['user_id']);
                $previousUser = $msg['user_id'];
            @endphp

            {{-- Mensagem do próprio usuário (alinhada à direita) --}}
            @if($msg['user_id'] == Auth::id())
                <div class="mb-2 flex justify-end">
                    <div class="max-w-xs flex items-start">
                        {{-- Balão de mensagem --}}
                        <div class="bg-blue-500 text-white p-2 rounded-lg rounded-br-none">
                            {{-- Somente no chat público exibimos o nome na primeira mensagem consecutiva --}}
                            @if(!$isPrivateChat && $showHeader)
                                <div class="text-sm font-semibold text-right">{{ $msg['name'] }}</div>
                            @endif

                            <div class="text-sm">{{ $msg['message'] }}</div>

                            @if (!empty($msg['attachment']))
                                <div class="mt-1">
                                    <a href="{{ asset('storage/' . $msg['attachment']) }}" target="_blank"
                                       class="text-white underline flex items-center">
                                        @svg('bi-paperclip', 'w-5 h-5 text-white me-1')
                                        <span>Baixar Anexo</span>
                                    </a>
                                </div>
                            @endif

                            <div class="text-xs text-right text-blue-100 mt-1">
                                {{ $msg['created_at'] }}
                            </div>
                        </div>

                        {{-- Avatar do usuário ou placeholder (somente se chat público) --}}
                        @if(!$isPrivateChat)
                            @if($showHeader)
                                <div class="ml-2">
                                    @if (!empty($msg['profile_image']))
                                        <img src="{{ asset('storage/' . $msg['profile_image']) }}"
                                             alt="{{ $msg['name'] }}"
                                             class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        @svg('fas-user', 'h-8 w-8 text-gray-400')
                                    @endif
                                </div>
                            @else
                                {{-- Placeholder para manter alinhamento no chat público --}}
                                <div class="ml-2" style="width: 32px;"></div>
                            @endif
                        @endif
                    </div>
                </div>

            {{-- Mensagem de outro usuário (alinhada à esquerda) --}}
            @else
                <div class="mb-2 flex justify-start">
                    <div class="max-w-xs flex items-start">
                        @if(!$isPrivateChat)
                            @if($showHeader)
                                <div class="mr-2">
                                    @if (!empty($msg['profile_image']))
                                        <img src="{{ asset('storage/' . $msg['profile_image']) }}"
                                             alt="{{ $msg['name'] }}"
                                             class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        @svg('fas-user', 'h-8 w-8 text-gray-400')
                                    @endif
                                </div>
                            @else
                                {{-- Placeholder para manter alinhamento no chat público --}}
                                <div class="mr-2" style="width: 32px;"></div>
                            @endif
                        @endif

                        <div class="bg-gray-200 text-gray-800 p-2 rounded-lg rounded-bl-none">
                            @if(!$isPrivateChat && $showHeader)
                                <div class="text-sm font-semibold">{{ $msg['name'] }}</div>
                            @endif

                            <div class="text-sm">{{ $msg['message'] }}</div>

                            @if (!empty($msg['attachment']))
                                <div class="mt-1">
                                    <a href="{{ asset('storage/' . $msg['attachment']) }}" target="_blank"
                                       class="text-blue-500 hover:underline flex items-center">
                                        @svg('bi-paperclip', 'w-5 h-5 text-blue-400 me-1')
                                        <span>Baixar Anexo</span>
                                    </a>
                                </div>
                            @endif

                            <div class="text-xs text-right text-gray-500 mt-1">
                                {{ $msg['created_at'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

    @else
        <p class="text-gray-500">Nenhuma mensagem disponível.</p>
    @endif
</div>
