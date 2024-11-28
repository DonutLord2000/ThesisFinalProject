<?php

namespace App\Http\Controllers\Alumni;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Alumnus;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumnus::all();
        return view('alumni.index', compact('alumni'));
    }

    public function show(Alumnus $alumnus)
    {
        return view('alumni.show', compact('alumnus'));
    }

    public function edit(Alumnus $alumnus)
    {
        return view('alumni.edit', compact('alumnus'));
    }

    public function update(Request $request, Alumnus $alumnus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year_graduated' => 'required|integer',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:Male,Female,Other',
            'marital_status' => 'nullable|string|max:255',
            'current_location' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'degree_program' => 'required|string|max:255',
            'major' => 'nullable|string|max:255',
            'minor' => 'nullable|string|max:255',
            'gpa' => 'nullable|numeric|between:0,4.00',
            'employment_status' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'nature_of_work' => 'nullable|string|max:255',
            'employment_sector' => 'nullable|string|max:255',
            'tenure_status' => 'nullable|string|max:255',
            'monthly_salary' => 'nullable|numeric',
        ]);

        $alumnus->update($validated);

        return redirect()->route('alumni.show', $alumnus)->with('success', 'Alumnus updated successfully.');
    }

    public function destroy(Alumnus $alumnus)
    {
        $alumnus->delete();
        return redirect()->route('alumni.index')->with('success', 'Alumnus deleted successfully.');
    }
}