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
        $threads = Thread::withCount(['comments', 'upvotes', 'hearts'])
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('threads.index', compact('threads'));
    }

    public function show(Thread $thread)
    {
        $thread->load('user', 'comments.user');
        $thread->loadCount(['comments', 'upvotes', 'hearts']);

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

    public function react(Request $request, Thread $thread)
    {
        $type = $request->input('type');
        $user = auth()->user();

        $reaction = $thread->reactions()->where('user_id', $user->id)->where('type', $type)->first();

        if ($reaction) {
            $reaction->delete();
            $message = 'Reaction removed';
        } else {
            $thread->reactions()->create([
                'user_id' => $user->id,
                'type' => $type,
            ]);
            $message = 'Reaction added';
        }

        // Recalculate the counts
        $counts = [
            'upvotes' => $thread->reactions()->where('type', 'upvote')->count(),
            'hearts' => $thread->reactions()->where('type', 'heart')->count(),
        ];

        return response()->json(['message' => $message, 'counts' => $counts]);
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
}