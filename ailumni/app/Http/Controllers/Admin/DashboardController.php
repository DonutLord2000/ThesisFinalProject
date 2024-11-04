<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $studentsCount = User::where('role', 'student')->count();
        $alumniCount = User::where('role', 'alumni')->count();

        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        $newStudentsThisMonth = User::where('role', 'student')->whereMonth('created_at', now()->month)->count();

        // Calculate employment rate using the is_employed field
        $employedAlumni = User::where('role', 'alumni')->where('is_employed', 'yes')->count();
        $employmentRate = $alumniCount > 0 ? round(($employedAlumni / $alumniCount) * 100) : 0;

        // Prepare data for monthly registrations chart
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $date->format('M');
            $monthlyData[] = User::whereYear('created_at', $date->year)
                                 ->whereMonth('created_at', $date->month)
                                 ->count();
        }

        // Prepare data for alumni employment chart
        $employmentLabels = [Carbon::now()->subYear()->year, Carbon::now()->year, Carbon::now()->addYear()->year];
        $employmentData = [];

        foreach ($employmentLabels as $year) {
            $totalAlumni = User::where('role', 'alumni')
                               ->whereYear('created_at', '<=', $year)
                               ->count();

            $employedAlumni = User::where('role', 'alumni')
                                  ->where('is_employed', 'yes')
                                  ->whereYear('created_at', '<=', $year)
                                  ->count();

            $yearEmploymentRate = $totalAlumni > 0 ? round(($employedAlumni / $totalAlumni) * 100) : 0;
            $employmentData[] = $yearEmploymentRate;
        }

        // Calculate active users (this is a simplified version, you might want to adjust based on your definition of "active")
        $dailyActiveUsers = User::where('last_login_at', '>=', Carbon::now()->subDay())->count();
        $weeklyActiveUsers = User::where('last_login_at', '>=', Carbon::now()->subWeek())->count();
        $monthlyActiveUsers = User::where('last_login_at', '>=', Carbon::now()->subMonth())->count();

        return view('dashboard', compact(
            'totalUsers', 'studentsCount', 'alumniCount',
            'newUsersThisMonth', 'newStudentsThisMonth', 'employmentRate',
            'monthlyLabels', 'monthlyData',
            'employmentLabels', 'employmentData',
            'dailyActiveUsers', 'weeklyActiveUsers', 'monthlyActiveUsers'
        ));
    }
}