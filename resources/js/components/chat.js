document.addEventListener("DOMContentLoaded", function () {
    function subscribeToChat() {
        window.Echo.channel('chat')
            .listen('.MessageSent', (e) => {
                if (window.Livewire) {
                    window.Livewire.dispatch('messageReceived', e.message);
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

    // Função para verificar se o scroll está no final
    function isChatScrolledToBottom(chatBox) {
        return chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 5;
    }

    // Rolagem automática ao adicionar mensagens, se já estiver no final antes da atualização
    document.addEventListener('livewire:update', () => {
        const chatBox = document.getElementById('chat-box');
        if (chatBox) {
            const shouldScroll = isChatScrolledToBottom(chatBox);
            if (shouldScroll) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        }
    });

    // Força rolagem para o final após o envio de uma nova mensagem
    window.addEventListener('forceScrollToBottom', () => {
        const chatBox = document.getElementById('chat-box');
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });

    // Focar input após envio
    window.addEventListener('clearChatInput', () => {
        const chatInput = document.getElementById('chat-input');
        if (chatInput) {
            chatInput.value = '';
            chatInput.focus();
        }
    });
});
