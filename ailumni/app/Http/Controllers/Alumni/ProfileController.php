<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Experience;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user()->load(['profile', 'experiences', 'education']);
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|max:1024',
            'cover_picture' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        if ($request->hasFile('profile_picture')) {
            if ($profile->profile_picture) {
                Storage::delete($profile->profile_picture);
            }
            $profile->profile_picture = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        if ($request->hasFile('cover_picture')) {
            if ($profile->cover_picture) {
                Storage::delete($profile->cover_picture);
            }
            $profile->cover_picture = $request->file('cover_picture')->store('cover-pictures', 'public');
        }

        $profile->fill($request->only(['address', 'contact_number', 'bio']));
        $profile->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully');
    }

    public function addExperience(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'current_role' => 'boolean',
            'location' => 'required|string|max:255',
            'location_type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->experiences()->create($validated);

        return redirect()->route('profile.edit')->with('success', 'Experience added successfully');
    }

    public function addEducation(Request $request)
    {
        $validated = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'grade' => 'nullable|string|max:255',
            'activities' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        auth()->user()->education()->create($validated);

        return redirect()->route('profile.edit')->with('success', 'Education added successfully');
    }

    public function destroyExperience($id)
    {
        $experience = auth()->user()->experiences()->findOrFail($id);
        $experience->delete();

        return redirect()->route('profile.edit')->with('success', 'Experience deleted successfully');
    }

    public function destroyEducation($id)
    {
        $education = auth()->user()->education()->findOrFail($id);
        $education->delete();

        return redirect()->route('profile.edit')->with('success', 'Education deleted successfully');
    }


}