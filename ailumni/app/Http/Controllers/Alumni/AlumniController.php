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
    $alumni = User::alumni()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_info', 'like', "%{$search}%")
                  ->orWhere('jobs', 'like', "%{$search}%")
                  ->orWhere('achievements', 'like', "%{$search}%");
            });
        })
        ->orderBy($sortColumn, $sortDirection)
        ->paginate(10);

    // Check if the request is an AJAX request
    if ($request->ajax()) {
        return view('alumni.partials.table_rows', compact('alumni'));
    }

    // For non-AJAX requests, return the full view
    return view('alumni.profile.index', compact('alumni', 'sortColumn', 'sortDirection', 'search'));
}

    public function view($name)
    {
        $alumni = User::where('name', $name)->firstOrFail(); // Fetch the alumni profile by name
        return view('alumni.profile.view', compact('alumni'));
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
