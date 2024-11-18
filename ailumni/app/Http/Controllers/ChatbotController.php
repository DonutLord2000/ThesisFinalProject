<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // User information for the system role
            $userInfo = [
                'name' => $user->name,
                'email' => $user->email,
            ];

            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are AI-Lumni, a helpful assistant. You have access to the following alumni information:'. json_encode($userInfo)],
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
