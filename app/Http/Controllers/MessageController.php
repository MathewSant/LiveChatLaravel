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
    
    public function store(Request $request)
    {
        Log::info('Recebendo requisição:', $request->all()); // Log para depuração
    
        $request->validate([
            'name' => 'required',
            'message' => 'required',
        ]);
        $message = Message::create([
            'name' => $request->name,
            'message' => $request->message,
        ]);
    
        broadcast(new MessageSent($message))->toOthers();
    
        return response()->json($message);
    }
    
}
