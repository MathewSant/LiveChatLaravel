<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Events\UserTyping;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Chat extends Component
{
    public $message;
    public $messages = [];
    
    // Adicione o listener para atualizar as mensagens
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
                    'name'    => $message->name,
                    'message' => $message->message,
                ];
            })->toArray();
    }
    

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required',
        ]);

        $user = Auth::user();

        $message = Message::create([
            'user_id' => $user->id,
            'name'    => $user->name,
            'message' => $this->message,
        ]);

        broadcast(new MessageSent($message));

        // Atualiza localmente a lista de mensagens
        $this->messages = array_merge($this->messages ?? [], [
            [
                'name'    => $message->name,
                'message' => $message->message,
            ]
        ]);

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
