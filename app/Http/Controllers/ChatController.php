<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetchMessages()
    {
        return response()->json(Message::with('user')->get());
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $message = Auth::user()->messages()->create([
            'Message' => $request->input('message')
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }
}
