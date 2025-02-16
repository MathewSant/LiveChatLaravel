<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipient_id', // Certifique-se de incluir este campo
        'name',
        'message',
        'attachment',
    ];
}
