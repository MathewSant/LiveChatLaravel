// Exemplo de chat.js já visto:
document.addEventListener("DOMContentLoaded", function () {
    function subscribeToChat() {
        window.Echo.channel('chat')
            .listen('.MessageSent', (e) => {
                if (window.Livewire) {
                    // Dependendo da versão, use dispatch ou emit
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

    // Limpar e focar no input após envio
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
    if(chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});

window.addEventListener('clearChatInput', event => {
    const chatInput = document.getElementById('chat-input');
    if(chatInput) {
        chatInput.value = '';
        chatInput.focus();
    }
});