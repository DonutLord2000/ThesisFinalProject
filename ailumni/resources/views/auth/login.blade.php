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
                        <x-input id="password" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm" type="password" name="password" required autocomplete="current-password" />
                    </div>

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