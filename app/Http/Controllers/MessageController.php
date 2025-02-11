<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->take(10)->get()->toArray();
        Log::info("Mensagens retornadas:", $messages);
        return response()->json($messages);
    }
}
