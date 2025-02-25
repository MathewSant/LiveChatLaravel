<?php

// app/Livewire/Chat/Chat.php

namespace App\Livewire\Chat;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\Chat\ChatService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Chat extends Component
{
    use WithFileUploads;

    public $message;
    public $messages = [];
    public $attachment;

    public $users = [];
    public $selectedUserId = null;

    protected $listeners = [
        'messageReceived' => 'loadMessages',
    ];

    protected ChatService $chatService;

    public function boot(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function mount()
    {
        $this->loadMessages();
        $this->users = User::where('id', '!=', Auth::id())->get();
    }

    public function render()
    {
        $selectedUser = $this->selectedUserId ? User::find($this->selectedUserId) : null;
        $isPrivateChat = $selectedUser ? true : false;
        
        return view('livewire.chat', [
            'messages'     => $this->messages,
            'users'        => $this->users,
            'selectedUser' => $selectedUser,
            'isPrivateChat' => $isPrivateChat,
        ]);
    }
    
   
    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->loadMessages();
    }
    
    public function clearSelectedUser()
    {
        $this->selectedUserId = null;
        $this->loadMessages();
    }

    public function emitTyping()
    {
        $this->chatService->emitTyping();
    }

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