<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $request->input('message')],
                ],
            ]);

            $reply = $result['choices'][0]['message']['content'] ?? 'Sorry, I could not generate a response.';
        } catch (\Exception $e) {
            $reply = 'Error: ' . $e->getMessage();
        }

        return response()->json([
            'reply' => $reply,
        ]);
    }
}
