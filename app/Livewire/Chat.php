<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Events\UserTyping;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

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

    public function emitTyping()
    {
        $user = Auth::user();
        if ($user) {
            broadcast(new UserTyping($user->name));
        }
    }

    public function mount()
    {
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::latest()->take(10)->get()
            ->reverse()
            ->map(function ($message) {
                return [
                    'name'       => $message->name,
                    'message'    => $message->message,
                    'attachment' => $message->attachment,
                ];
            })->toArray();
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'nullable|string', // Pode ser nulo se houver um anexo
            'attachment' => 'nullable|file|max:2048', // Pode ser nulo se houver uma mensagem
        ]);
    
        // Verifica se a mensagem e o anexo estão ambos vazios
        if (empty($this->message) && !$this->attachment) {
            $this->addError('message', 'Digite uma mensagem ou envie um arquivo.');
            return;
        }
    
        $user = Auth::user();
        $attachmentPath = null;
    
        // Se um arquivo for enviado, salva no storage
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('uploads', 'public');
        }
    
        $message = Message::create([
            'user_id'    => $user->id,
            'name'       => $user->name,
            'message'    => $this->message ?? '', // Evita NULL
            'attachment' => $attachmentPath,
        ]);
    
        broadcast(new MessageSent($message));
    
        // Atualiza a lista de mensagens
        $this->messages[] = [
            'name'       => $message->name,
            'message'    => $message->message,
            'attachment' => $attachmentPath,
        ];
    
        // Limpa os campos
        $this->message = '';
        $this->attachment = null;
    
        // Dispara um evento para limpar o input no front-end
        $this->dispatch('clearChatInput');
    }
    

    public function render()
    {
        return view('livewire.chat');
    }
}
