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

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <x-label for="email" value="{{ __('Email') }}" class="text-gray-700 font-semibold" />
                        <x-input id="email" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mb-4">
                        <x-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-semibold" />
                        <div class="relative">
                            <input id="password" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm pr-10" type="password" name="password" required autocomplete="current-password" />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword()">
                                <svg id="eye-icon" class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.27.842-.678 1.633-1.21 2.344M15.73 15.73a9 9 0 01-9.458 0"></path>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <script>
                        function togglePassword() {
                            const passwordField = document.getElementById("password");
                            const eyeIcon = document.getElementById("eye-icon");

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


                    <div class="flex items-center justify-between mb-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" class="rounded-md" />
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        <div class="">
                            <a href="{{ route('register') }}" class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Don't have an account? Register
                            </a>
                        </div>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="mt-4 mb-4 text-center underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <div class="flex items-center justify-end">
                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>
        </div>
    </div>
</x-guest-layout>