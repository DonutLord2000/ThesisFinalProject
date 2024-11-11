<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\NewsPost;

class DashboardController extends Controller
{
    public function index()
    {
    $totalUsers = User::count();
    $studentsCount = User::where('role', 'student')->count();
    $alumniCount = User::where('role', 'alumni')->count();

    $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
    $newStudentsThisMonth = User::where('role', 'student')->whereMonth('created_at', now()->month)->count();

    // Employment Data for Pie Chart
    $employedCount = User::where('role', 'alumni')->where('is_employed', 'yes')->count();
    $unemployedCount = User::where('role', 'alumni')->where('is_employed', 'no')->count();
    $unknownCount = User::where('role', 'alumni')->where('is_employed', 'unknown')->count();
    $employmentData = [$employedCount, $unemployedCount, $unknownCount];

    // Calculate overall employment rate
    $employmentRate = $alumniCount > 0 ? round(($employedCount / $alumniCount) * 100) : 0;

    // User Registrations Data
    $dailyRegistrations = $this->getRegistrations('daily', 30);
    $monthlyRegistrations = $this->getRegistrations('monthly', 12);
    $yearlyRegistrations = $this->getRegistrations('yearly', 5);

    // Active Users
    $now = Carbon::now();

    $dailyActiveUsers = User::where('last_login_at', '>=', $now->copy()->subDay())->count();
    $weeklyActiveUsers = User::where('last_login_at', '>=', $now->copy()->subWeek())->count();
    $monthlyActiveUsers = User::where('last_login_at', '>=', $now->copy()->subMonth())->count();

    $previousDayUsers = User::where('last_login_at', '>=', $now->copy()->subDays(2))
        ->where('last_login_at', '<', $now->copy()->subDay())
        ->count();
    $previousWeekUsers = User::where('last_login_at', '>=', $now->copy()->subWeeks(2))
        ->where('last_login_at', '<', $now->copy()->subWeek())
        ->count();
    $previousMonthUsers = User::where('last_login_at', '>=', $now->copy()->subMonths(2))
        ->where('last_login_at', '<', $now->copy()->subMonth())
        ->count();

    $dailyActiveUsersGrowth = $this->calculateGrowth($dailyActiveUsers, $previousDayUsers);
    $weeklyActiveUsersGrowth = $this->calculateGrowth($weeklyActiveUsers, $previousWeekUsers);
    $monthlyActiveUsersGrowth = $this->calculateGrowth($monthlyActiveUsers, $previousMonthUsers);


    $newsPosts = NewsPost::where(function($query) {
        if (auth()->user()->role === 'admin') {
            // Admin can see all posts
            $query->whereNotNull('id');
        } else {
            // Other roles see posts visible to everyone or their specific role
            $query->where('visible_to', 'everyone')
                  ->orWhere('visible_to', auth()->user()->role);
        }})
    ->orderBy('created_at', 'desc')
    ->take(10) // Limit numbers to most recent posts, adjust as needed
    ->get();


    return view('dashboard', compact(
        'totalUsers', 'studentsCount', 'alumniCount',
        'newUsersThisMonth', 'newStudentsThisMonth', 'employmentRate',
        'employmentData',
        'dailyRegistrations', 'monthlyRegistrations', 'yearlyRegistrations',
        'dailyActiveUsers', 'weeklyActiveUsers', 'monthlyActiveUsers',
        'dailyActiveUsersGrowth','weeklyActiveUsersGrowth','monthlyActiveUsersGrowth',
        'newsPosts',
    ));
}

private function getRegistrations($period, $limit)
{
    switch ($period) {
        case 'daily':
            $query = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays($limit))
            ->groupBy('date')
            ->orderBy('date');
            $format = 'M d';
            break;
        case 'monthly':
            $query = User::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths($limit))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month');
            $format = 'M Y';
            break;
        case 'yearly':
            $query = User::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subYears($limit))
            ->groupBy('year')
            ->orderBy('year');
            $format = 'Y';
            break;
    }

    $results = $query->get();

    $labels = $results->map(function ($item) use ($format, $period) {
        switch ($period) {
            case 'daily':
                return Carbon::parse($item->date)->format($format);
            case 'monthly':
                return Carbon::createFromDate($item->year, $item->month, 1)->format($format);
            case 'yearly':
                return $item->year;
        }
    })->toArray();

    $data = $results->pluck('count')->toArray();

    return [
        'labels' => $labels,
        'data' => $data
    ];
}

private function calculateGrowth(int $current, int $previous): float
    {
        if ($previous > 0) {
            return round((($current - $previous) / $previous) * 100, 2);
        }
        return $current > 0 ? 100 : 0;
    }
}