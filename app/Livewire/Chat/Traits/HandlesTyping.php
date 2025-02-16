<?php 

namespace App\Livewire\Chat\Traits;

trait HandlesTyping
{
    public function emitTyping()
    {
        $this->chatService->emitTyping();
    }
}