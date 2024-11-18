<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsPostController extends Controller
{
    public function index()
    {
        $posts = NewsPost::where(function($query) {
            if (auth()->user()->role === 'admin') {
                // Admin can see all posts
                $query->whereNotNull('id');
            } else {
                // Other roles see posts visible to everyone or their specific role
                $query->where('visible_to', 'everyone')
                      ->orWhere('visible_to', auth()->user()->role);
            }})
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('news.dashboard', compact('posts'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visible_to' => 'required|in:students,alumni,everyone',
            'source' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:20480',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $validated['image'] = $imagePath;
        }

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('news_videos', 'public');
            $validated['video'] = $videoPath;
        }

        $post = NewsPost::create($validated);

        return redirect()->route('news.index')->with('success', 'News post created successfully.');
    }

    public function destroy(NewsPost $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        if ($post->video) {
            Storage::disk('public')->delete($post->video);
        }
        $post->delete();
        return redirect()->route('news.index')->with('success', 'News post deleted successfully.');
    }
}