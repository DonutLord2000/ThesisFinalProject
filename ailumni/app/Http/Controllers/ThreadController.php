<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::with('user')->withCount(['reactions as upvotes' => function ($query) {
            $query->where('type', 'upvote');
        }, 'reactions as hearts' => function ($query) {
            $query->where('type', 'heart');
        }])->latest()->paginate(15);

        return view('threads.index', compact('threads'));
    }

    public function show(Thread $thread)
    {
        $thread->load('user', 'comments.user');
        $thread->loadCount(['reactions as upvotes' => function ($query) {
            $query->where('type', 'upvote');
        }, 'reactions as hearts' => function ($query) {
            $query->where('type', 'heart');
        }]);

        return view('threads.show', compact('thread'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $thread = auth()->user()->threads()->create($validated);

        return redirect()->route('threads.show', $thread);
    }

    public function storeComment(Request $request, Thread $thread)
    {
        $validated = $request->validate([
            'content' => 'required',
        ]);

        $thread->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back();
    }

    public function react(Request $request, Thread $thread)
    {
        $type = $request->input('type');

        if (!in_array($type, ['upvote', 'heart'])) {
            return response()->json(['message' => 'Invalid reaction type'], 400);
        }

        $reaction = $thread->reactions()->where('user_id', auth()->id())->where('type', $type)->first();

        if ($reaction) {
            $reaction->delete();
            $message = 'Reaction removed';
        } else {
            $thread->reactions()->create([
                'user_id' => auth()->id(),
                'type' => $type,
            ]);
            $message = 'Reaction added';
        }

        $counts = [
            'upvotes' => $thread->reactions()->where('type', 'upvote')->count(),
            'hearts' => $thread->reactions()->where('type', 'heart')->count(),
        ];

        return response()->json(['message' => $message, 'counts' => $counts]);
    }
}