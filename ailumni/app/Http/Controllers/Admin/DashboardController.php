<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
{
    $totalUsers = User::count();
    $studentsCount = User::where('role', 'student')->count();
    $alumniCount = User::where('role', 'alumni')->count();

    $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
    $newStudentsThisMonth = User::where('role', 'student')->whereMonth('created_at', now()->month)->count();

    // Calculate employment rate (you'll need to adjust this based on your data structure)
    $employedAlumni = User::where('role', 'alumni')->where('is_employed', 'yes')->count();
    $employmentRate = $alumniCount > 0 ? round(($employedAlumni / $alumniCount) * 100) : 0;

    // Prepare data for monthly registrations chart
    $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    $monthlyData = [/* Fetch actual monthly registration data */];

    // Prepare data for alumni employment chart
    $employmentLabels = ['2023', '2024', '2025'];
    $employmentData = [/* Fetch actual employment rate data */];

    // Active users data (you'll need to implement the logic to calculate these)
    $dailyActiveUsers = 0; // Implement logic to get daily active users
    $weeklyActiveUsers = 0; // Implement logic to get weekly active users
    $monthlyActiveUsers = 0; // Implement logic to get monthly active users

    return view('dashboard', compact(
        'totalUsers', 'studentsCount', 'alumniCount',
        'newUsersThisMonth', 'newStudentsThisMonth', 'employmentRate',
        'monthlyLabels', 'monthlyData',
        'employmentLabels', 'employmentData',
        'dailyActiveUsers', 'weeklyActiveUsers', 'monthlyActiveUsers'
    ));
    }
}
