<?php

namespace App\Services\Chat;

use App\Repositories\Chat\MessageRepository;
use App\Events\MessageSent;
use App\Events\UserStoppedTyping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ChatService
{
    protected $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retorna as mensagens já formatadas para exibição.
     */
    public function loadMessages()
    {
        $messages = $this->repository->getAllMessages();
        return $messages->map(function ($message) {
            return [
                'name'       => $message->name,
                'message'    => $message->message,
                'attachment' => $message->attachment,
            ];
        })->toArray();
    }

    /**
     * Cria e envia a mensagem.
     */
    public function sendMessage(?string $text, $attachmentPath = null)
    {
        $user = Auth::user();

        $data = [
            'user_id'    => $user->id,
            'name'       => $user->name,
            'message'    => $text ?? '',
            'attachment' => $attachmentPath,
        ];

        $message = $this->repository->createMessage($data);

        broadcast(new MessageSent($message));
        broadcast(new UserStoppedTyping($user->name))->toOthers();

        return $message;
    }

  
    public function emitTyping()
    {
        $user = Auth::user();
        if ($user && !Cache::has("typing_{$user->id}")) {
            broadcast(new \App\Events\UserTyping($user->name))->toOthers();
            Cache::put("typing_{$user->id}", true, now()->addMilliseconds(500));
        }
    } 
}
