<?php

namespace App\Http\Controllers\Alumni;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlumniController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    // Set default sort column and direction
    $sortColumn = $request->get('sort', 'name'); // Default to sorting by name
    $sortDirection = $request->get('direction', 'asc'); // Default to ascending order

    // Validate sort column and direction
    $allowedSorts = ['name', 'email'];
    if (!in_array($sortColumn, $allowedSorts) || !in_array($sortDirection, ['asc', 'desc'])) {
        $sortColumn = 'name';
        $sortDirection = 'asc';
    }

    // Retrieve only users with the role 'alumni'
    $alumni = User::alumni() // Use the scope here
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_info', 'like', "%{$search}%")
                  ->orWhere('jobs', 'like', "%{$search}%")
                  ->orWhere('achievements', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        })
    ->orderBy($sortColumn, $sortDirection) // Sort based on the selected column and direction
    ->paginate(10);

    return view('alumni.profile.index', compact('alumni', 'sortColumn', 'sortDirection', 'search'));
    }


    public function show(User $user)
    {
        return view('alumni.profile.index', compact('user'));
    }

    public function create()
    {
        return view('alumni.profile.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact_info' => 'nullable|string|max:255',
            'jobs' => 'nullable|string',
            'achievements' => 'nullable|string',
            'bio' => 'nullable|string',
            'profile_photo_url' => 'nullable|url'
        ]);

        User::create(array_merge($request->all(), ['role' => 'alumni']));

        return redirect()->route('alumni.profile.index')->with('success', 'Alumni added successfully.');
    }
}