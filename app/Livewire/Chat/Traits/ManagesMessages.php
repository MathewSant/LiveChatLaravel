<?php

namespace App\Livewire\Chat\Traits;

trait ManagesMessages
{
    public function loadMessages()
    {
        $recipientId = $this->selectedUserId ? $this->selectedUserId : null;
        $this->messages = $this->chatService->loadMessages($recipientId);

        $this->dispatch('updateMessages', ['messages' => $this->messages]);
    }

    public function sendMessage()
    {
        $this->validate([
            'message'    => 'nullable|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        if (empty($this->message) && !$this->attachment) {
            $this->addError('message', 'Digite uma mensagem ou envie um arquivo.');
            return;
        }

        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('uploads', 'public');
        }

        // Usa o ID do usuário selecionado
        $recipientId = $this->selectedUserId ? $this->selectedUserId : null;
        $this->chatService->sendMessage($this->message, $attachmentPath, $recipientId);
        $this->loadMessages();

        $this->message = '';
        $this->attachment = null;

        $this->dispatch('clearChatInput');
        $this->dispatch('forceScrollToBottom');
    }
}
