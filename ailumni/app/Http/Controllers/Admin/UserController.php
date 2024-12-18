<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    
     public function index(Request $request)
{
    // Default sort column and direction
    $sortColumn = $request->get('sort', 'name'); 
    $sortDirection = $request->get('direction', 'asc'); 

    // Validate sort column and direction
    $validSortColumns = ['name', 'email', 'role', 'student_id'];
    $validSortDirections = ['asc', 'desc'];

    if (!in_array($sortColumn, $validSortColumns) || !in_array($sortDirection, $validSortDirections)) {
        $sortColumn = 'name';
        $sortDirection = 'asc';
    }

    // Get search query
    $search = $request->get('search');

    // Fetch users with search and sort
    $users = User::when($search, function ($query) use ($search) {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('student_id', 'like', '%' . $search . '%');
        });
    })
    ->orderBy($sortColumn, $sortDirection)
    ->get();

    // Check if the request is an AJAX request
    if ($request->ajax()) {
        return view('admin.users.partials.table_rows', compact('users'))->render();
    }

    // Pass the users, sort column, sort direction, and search term to the main view
    return view('admin.users.index', compact('users', 'sortColumn', 'sortDirection', 'search'));
}


    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in the database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string',
            'student_id' => 'required|string',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'], // Assuming role_id is an integer
            'student_id' => $validatedData['student_id'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in the database.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'student_id' => 'required|string',
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from the database.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
