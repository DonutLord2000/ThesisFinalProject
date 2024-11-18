<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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
                'bio' => $user->bio ?? 'No bio provided.',
                'jobs' => $user->jobs ?? 'No jobs listed.',
                'achievements' => $user->achievements ?? 'No achievements provided.',
            ];

            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are AI-Lumni, a helpful assistant. You have access to the following alumni information:'. json_encode($userInfo)],
                    ['role' => 'user', 'content' => $request->input('message')],
                ],
                'max_tokens' => 750, // Limit to approximately 500 words
            ]);

            $reply = $result['choices'][0]['message']['content'] ?? 'Sorry, I could not generate a response.';
            $wordArray = explode(' ', $reply);
            if (count($wordArray) > 500) {
                $reply = implode(' ', array_slice($wordArray, 0, 500)) . '...';
            }
        } catch (\Exception $e) {
            $reply = 'An error occurred while processing your request.' . $e->getMessage();
        }

        return response()->json([
            'reply' => $reply, 200
        ]);
    }
}
