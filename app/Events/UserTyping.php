<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;

    /**
     * Cria uma nova instância do evento.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Define em qual canal o evento será transmitido.
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }

    /**
     * Nome personalizado para o evento no broadcast.
     */
    public function broadcastAs()
    {
        return 'UserTyping';
    }
}
