<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        // Count all users
        $totalUsers = User::count();

        // Count users with 'student' role
        $studentsCount = User::where('role', 'student')->count();

        // Count users with 'alumni' role
        $alumniCount = User::where('role', 'alumni')->count();

        return view('dashboard', compact('totalUsers', 'studentsCount', 'alumniCount'));
    }
}