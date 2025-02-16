<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository
{
  
    public function getAllMessages()
    {
        return Message::latest()->get()->reverse();
    }

    public function createMessage(array $data)
    {
        return Message::create($data);
    }
}
