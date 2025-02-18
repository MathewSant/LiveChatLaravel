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


    // Força rolagem para o final após o envio de uma nova mensagem
    window.addEventListener('forceScrollToBottom', () => {
        const chatBox = document.getElementById('chat-box');
        if (chatBox) {
            setTimeout(() => {
                chatBox.scrollTop = chatBox.scrollHeight;
            }, 100);
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
