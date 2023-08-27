<?php

namespace App\Http\Controllers\Api;

use App\Events\Message as EventsMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatRequest;
use App\Models\Message;

class ChatController extends Controller
{
    public function sendMessage(ChatRequest $request)
    {
        $message = new Message([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        $message->save();
        event(new EventsMessage('message created',$request->message));
        return response()->json(['message' => 'Message sent successfully']);
    }

    public function getMessages(ChatRequest $request)
    {
        

        $user1_id = $request->user1_id;
        $user2_id = $request->user2_id;

        // Get messages sent by user1 to user2
        $messages1To2 = Message::where('sender_id', $user1_id)->where('receiver_id', $user2_id)->get();

        // Get messages sent by user2 to user1
        $messages2To1 = Message::where('sender_id', $user2_id)->where('receiver_id', $user1_id)->get();

        // Combine the messages and sort them by created_at timestamp
        $allMessages = $messages1To2->concat($messages2To1)->sortBy('id');

        return response()->json(['messages' => $allMessages]);
    }
    public function deleteMessage($id)
{
    $message = Message::find($id);

    if (!$message) {
        return response()->json(['error' => 'Message not found'], 404);
    }

    // Check if the authenticated user is the owner of the message
    if ($message->sender_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $message->delete();

    return response()->json(['message' => 'Message deleted successfully'], 200);
}
}
