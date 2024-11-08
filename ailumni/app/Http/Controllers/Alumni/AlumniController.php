<?php

namespace App\Http\Controllers\Alumni;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortColumn = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        $showFullInfo = $request->boolean('showFullInfo', false);

        $allowedSorts = ['name', 'email'];
        if (!in_array($sortColumn, $allowedSorts) || !in_array($sortDirection, ['asc', 'desc'])) {
            $sortColumn = 'name';
            $sortDirection = 'asc';
        }

        $query = User::alumni()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('contact_info', 'like', "%{$search}%")
                      ->orWhere('jobs', 'like', "%{$search}%")
                      ->orWhere('achievements', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortColumn, $sortDirection);

        $alumni = $query->paginate(20);

        // Mask sensitive information if not showing full info
        if (!$showFullInfo) {
            $alumni->getCollection()->transform(function ($alum) {
                $alum->email = $this->maskString($alum->email);
                $alum->contact_info = $this->maskString($alum->contact_info);
                return $alum;
            });
        }

        if ($request->ajax()) {
            return view('alumni.partials.table_rows', compact('alumni', 'showFullInfo'));
        }

        $userCanViewFullInfo = auth()->user() && in_array(auth()->user()->role, ['student', 'alumni', 'admin']);

        return view('alumni.profile.index', compact('alumni', 'sortColumn', 'sortDirection', 'showFullInfo', 'userCanViewFullInfo'));
    }

    public function view($name)
    {
        $alumni = User::alumni()->where('name', $name)->firstOrFail();
        
        if (!auth()->user() || !in_array(auth()->user()->role, ['student', 'alumni', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('alumni.profile.view', compact('alumni'));
    }

    private function maskString($string)
    {
        $length = Str::length($string);
        if ($length <= 5) {
            return $string; // Return the original string if it's 5 characters or less
        }
        return Str::substr($string, 0, 5) . str_repeat('*', $length - 5);
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
