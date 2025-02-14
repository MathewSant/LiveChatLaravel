<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Events\UserStoppedTyping;
use App\Events\UserTyping;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;

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
            // Permite disparar imediatamente se não houver cache
            if (!Cache::has("typing_{$user->id}")) {
                broadcast(new UserTyping($user->name))->toOthers();
                // Pode ajustar para um tempo menor, como 500ms
                Cache::put("typing_{$user->id}", true, now()->addMilliseconds(500));
            }
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
            
        // Dispara um evento para Alpine.js atualizar as mensagens no front-end
        $this->dispatch('updateMessages', ['messages' => $this->messages]);
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'nullable|string',
            'attachment' => 'nullable|file|max:2048',
        ]);
    
        if (empty($this->message) && !$this->attachment) {
            $this->addError('message', 'Digite uma mensagem ou envie um arquivo.');
            return;
        }
    
        $user = Auth::user();
        $attachmentPath = null;
    
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('uploads', 'public');
        }
    
        $message = Message::create([
            'user_id'    => $user->id,
            'name'       => $user->name,
            'message'    => $this->message ?? '',
            'attachment' => $attachmentPath,
        ]);
    
        broadcast(new MessageSent($message));
        broadcast(new UserStoppedTyping($user->name))->toOthers();

        $this->loadMessages();
    
        $this->message = '';
        $this->attachment = null;

        $this->dispatch('clearChatInput');
    }
    

    public function render()
    {
        return view('livewire.chat', ['messages' => $this->messages]);
    }
}
