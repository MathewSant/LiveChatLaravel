<?php

namespace App\Livewire;

use App\Events\MessageSent;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Http;

#[Layout('layouts.app')] // Aqui definimos o layout corretamente
class Chat extends Component
{
    public $name;
    public $message;
    public $messages = [];

    protected $listeners = ['messageReceived' => 'loadMessages'];

    public function mount()
    {
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::latest()->take(10)->get()->map(function ($message) {
            return [
                'name' => $message->name,
                'message' => $message->message,
            ];
        })->toArray();
        
        // Garante que sempre seja um array
        if (empty($this->messages)) {
            $this->messages = [];
        }
    }
    
    
    

    public function sendMessage()
    {
        $this->validate([
            'name' => 'required',
            'message' => 'required',
        ]);
    
        // Cria a mensagem no banco de dados
        $message = Message::create([
            'name' => $this->name,
            'message' => $this->message,
        ]);
    
        // Dispara o evento para o broadcast (para as outras abas)
        broadcast(new MessageSent($message))->toOthers();
    
        // Atualiza a lista de mensagens (pode ser refinado para exibir ordenação desejada)
        $this->messages = array_merge($this->messages ?? [], [
            [
                'name' => $message->name,
                'message' => $message->message,
            ]
        ]);
    
        // Limpa o campo de mensagem
        $this->message = '';
    }
    
    

    public function render()
    {
        return view('livewire.chat');
    }
}
