<?php

namespace App\Repositories\Chat;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    public function getAllMessages()
    {
        return Message::with('user') // eager load do usuário
                      ->whereNull('recipient_id')
                      ->latest()
                      ->get()
                      ->reverse();
    }
    
    /**
     * Retorna as mensagens trocadas entre o usuário logado e o usuário $recipientId.
     */
    public function getPrivateMessages($recipientId)
    {
        $userId = Auth::id();
        return Message::with('user') // eager load do usuário
            ->where(function ($query) use ($userId, $recipientId) {
                $query->where('user_id', $userId)
                      ->where('recipient_id', $recipientId);
            })
            ->orWhere(function ($query) use ($userId, $recipientId) {
                $query->where('user_id', $recipientId)
                      ->where('recipient_id', $userId);
            })
            ->latest()
            ->get()
            ->reverse();
    }

    public function createMessage(array $data)
    {
        return Message::create($data);
    }
}