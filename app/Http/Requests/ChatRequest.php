<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function sendMessageRules(): array
    {
        return [
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ];
    }

    // Validation rules for retrieving messages
    public function getMessagesRules(): array
    {
        return [
            'user1_id' => 'required|exists:users,id',
            'user2_id' => 'required|exists:users,id',
        ];
    }

    public function rules(): array
    {
        // Combine validation rules for all methods
        return[
            'send_message' => $this->sendMessageRules(),
            'get_messages' => $this->getMessagesRules(),
        ];
    }
}
