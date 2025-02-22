<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Godruoyi\Snowflake\Snowflake;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; 
    public $incrementing = false;
    protected $keyType = 'integer'; 

    protected $fillable = [
        'user_id',
        'recipient_id',
        'name',
        'message',
        'attachment',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($message) {
            $snowflake = app(Snowflake::class);
            $message->id = $snowflake->id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
