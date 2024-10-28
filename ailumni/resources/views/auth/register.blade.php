<x-guest-layout>
     <!-- Wrapper for background image and blur effect -->
     <div class="relative min-h-screen">
        <!-- Background image with blur applied -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/bg.png') }}'); filter: blur(8px);">
        </div>
        <!-- Overlay to darken the background for better contrast -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <!-- Content wrapper to ensure form is above the blurred background -->
        <div class="relative flex items-center justify-center min-h-screen">
            <x-authentication-card class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg backdrop-blur-none">
                <div>
                    <img src="{{ asset('images/grc.png') }}" alt="Logo" style="width: 350px; height: 170px;">
                </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Student Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <div class="relative">
                    <input id="password" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm pr-10" type="password" name="password" required autocomplete="new-password" />
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword('password', 'eye-icon-password')">
                        <svg id="eye-icon-password" class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.27.842-.678 1.633-1.21 2.344M15.73 15.73a9 9 0 01-9.458 0"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <div class="relative">
                    <input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm pr-10" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword('password_confirmation', 'eye-icon-confirm-password')">
                        <svg id="eye-icon-confirm-password" class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.27.842-.678 1.633-1.21 2.344M15.73 15.73a9 9 0 01-9.458 0"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <script>
                function togglePassword(fieldId, iconId) {
                    const passwordField = document.getElementById(fieldId);
                    const eyeIcon = document.getElementById(iconId);

                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        eyeIcon.classList.add("text-gray-700");
                        eyeIcon.classList.remove("text-gray-500");
                    } else {
                        passwordField.type = "password";
                        eyeIcon.classList.add("text-gray-500");
                        eyeIcon.classList.remove("text-gray-700");
                    }
                }
            </script>

            <style>
                .relative {
                        position: relative;
                    }

                    .absolute {
                        position: absolute;
                    }

                    .inset-y-0 {
                        top: 50%;
                        transform: translateY(-50%);
                    }

                    .right-0 {
                        right: 0;
                    }

                    .pr-3 {
                        padding-right: 0.75rem; /* Adjust if needed */
                    }
            </style>


            <div class="mt-4">
                <x-label for="role" value="{{ __('Register as:') }}" />
                <select name="role" x-model="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="student">Student</option>
                    <option value="alumni">Alumni</option>
                </select>
            </div>
            <div class="mt-4">
                <x-label for="student_id" value="{{ __('Licence Number') }}" />
                <x-input id="student_id" class="block mt-1 w-full" type="text" :value="old('student_id')" name="student_id" required />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>