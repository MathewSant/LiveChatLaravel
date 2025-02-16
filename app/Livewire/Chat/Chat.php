<?php

namespace App\Livewire\Chat;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ChatService;

#[Layout('layouts.app')]
class Chat extends Component
{
    use WithFileUploads;

    public $message;
    public $messages = [];
    public $attachment;

    protected $listeners = [
        'messageReceived' => 'loadMessages',
    ];

    // Injeção do serviço do chat
    protected ChatService $chatService;

    public function boot(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function mount()
    {
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = $this->chatService->loadMessages();
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

        // Envia a mensagem via service
        $this->chatService->sendMessage($this->message, $attachmentPath);

        // Atualiza a lista de mensagens
        $this->loadMessages();

        // Reseta os campos
        $this->message = '';
        $this->attachment = null;

        $this->dispatch('clearChatInput');
        $this->dispatch('forceScrollToBottom');
    }

    public function emitTyping()
    {
        $this->chatService->emitTyping();
    }

    public function render()
    {
        return view('livewire.chat', ['messages' => $this->messages]);
    }
}
