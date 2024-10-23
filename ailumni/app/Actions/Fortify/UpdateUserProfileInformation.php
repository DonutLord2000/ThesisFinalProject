<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        // Basic validation rules for all users
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];

        // Additional validation rules for alumni
        if ($user->role === 'alumni') {
            $rules = array_merge($rules, [
                'contact_info' => ['nullable', 'string', 'max:255'],
                'jobs' => ['nullable', 'string', 'max:255'],
                'achievements' => ['nullable', 'array'], // Change to array for handling multiple achievements
                'bio' => ['nullable', 'string'],
            ]);
        }

        Validator::make($input, $rules)->validateWithBag('updateProfileInformation');

        // Update the profile photo if provided
        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // Handle email verification for verified users
        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            // Update the user's basic information
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();

            // Also update the additional fields for alumni
            if ($user->role === 'alumni') {
                $user->forceFill([
                    'contact_info' => $input['contact_info'] ?? null,
                    'jobs' => $input['jobs'] ?? null,
                    'achievements' => isset($input['achievements']) ? implode(',', $input['achievements']) : null, // Convert array to comma-separated string
                    'bio' => $input['bio'] ?? null,
                ])->save();
            }
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
