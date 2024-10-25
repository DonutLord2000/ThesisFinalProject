<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\UpdateUserProfileInformation;

class UpdateAlumniProfileInformation extends Controller
{
    protected $updateUserProfileInformation;

    public function __construct(UpdateUserProfileInformation $updateUserProfileInformation)
    {
        $this->updateUserProfileInformation = $updateUserProfileInformation;
    }

    /**
     * Show the alumni profile.
     */
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user
        return view('alumni.profile.show', compact('user'));
    }

    /**
     * Validate and update the given user's profile information.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Define validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'contact_info' => ['nullable', 'string', 'max:255'],
            'jobs' => ['nullable', 'string', 'max:255'],
            'achievements' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
        ];

        // Call the update method from the UpdateUserProfileInformation action
        $this->updateUserProfileInformation->update($user, $request->all());

        // Validate the incoming request data
        Validator::make($request->all(), $rules)->validateWithBag('updateProfileInformation');

        // Call the update method from the UpdateUserProfileInformation action
        $this->updateUserProfileInformation->update($user, $request->all());

        // Redirect to the alumni profile show route
        return redirect()->route('alumni.profile.show', ['user' => $user]);
    }
    
    /**
     * Update the given verified user's profile information.
     *
     * @param User $user
     * @param array $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'contact_info' => $input['contact_info'] ?? null,
            'jobs' => $input['jobs'] ?? null,
            'achievements' => $input['achievements'] ?? '',
            'bio' => $input['bio'] ?? null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
