<?php

// app/Services/Chat/ChatService.php

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
     * Retorna as mensagens formatadas para exibição.
     * Se $recipientId for informado, carrega apenas as mensagens privadas da conversa.
     */
     public function loadMessages($recipientId = null)
     {
         if ($recipientId) {
             $messages = $this->repository->getPrivateMessages($recipientId);
         } else {
             $messages = $this->repository->getAllMessages();
         }
     
         return $messages->map(function ($message) {
             return [
                 'user_id'       => $message->user_id,
                 'name'          => $message->name,
                 'message'       => $message->message,
                 'attachment'    => $message->attachment,
                 'profile_image' => $message->user ? $message->user->profile_image : null,
                 'created_at'    => $message->created_at->format('H:i'),
             ];
         })->toArray();
     }
     
    /**
     * Cria e envia a mensagem.
     */
    public function sendMessage(?string $text, $attachmentPath = null, $recipientId = null)
    {
        $user = Auth::user();

        $data = [
            'user_id'      => $user->id,
            'recipient_id' => $recipientId,
            'name'         => $user->name,
            'message'      => $text ?? '',
            'attachment'   => $attachmentPath,
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