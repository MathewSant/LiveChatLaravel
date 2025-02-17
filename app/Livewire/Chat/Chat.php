<?php

// app/Livewire/Chat/Chat.php

namespace App\Livewire\Chat;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\Chat\ChatService;
use App\Livewire\Chat\Traits\ManagesMessages;
use App\Livewire\Chat\Traits\HandlesTyping;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Chat extends Component
{
    use WithFileUploads, ManagesMessages, HandlesTyping;

    public $message;
    public $messages = [];
    public $attachment;

    // Alterado: Armazena apenas o ID do usuário selecionado
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
        // Carrega todos os usuários, exceto o atual
        $this->users = User::where('id', '!=', Auth::id())->get();
    }

    public function render()
    {
        // Recupera o usuário selecionado para exibição (se houver)
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
} 