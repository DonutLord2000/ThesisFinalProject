@extends('layouts.admin')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-center text-2xl font-semibold mb-6">Create New User</h1>

        <div class="mx-auto bg-white shadow-md rounded-lg p-6" style="max-width: 400px;"> <!-- Custom max-width -->
            <form action="{{ route('admin.users.store') }}" method="POST">
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
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="role" value="{{ __('Register as:') }}" />
                    <select name="role" x-model="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="student">Student</option>
                        <option value="alumni">Alumni</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="mt-4">
                    <x-label for="student_id" value="{{ __('Licence Number') }}" />
                    <x-input id="student_id" class="block mt-1 w-full" type="text" :value="old('student_id')" name="student_id" required />
                </div>

                <button type="submit" class="mt-6 w-full btn-custom">
                    Create
                </button>
                    
                <style>
                    .btn-custom {
                        background-color: #ff6b6b; /* Light red */
                        color: white; /* Text color */
                        font-weight: 600; /* Semi-bold */
                        padding: 0.5rem; /* Vertical padding */
                        border-radius: 0.375rem; /* Rounded corners */
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
                        transition: background-color 0.3s, transform 0.3s;
                    }

                    .btn-custom:hover {
                        background-color: #ff4d4d; /* Darker shade on hover */
                        transform: scale(1.05); /* Slightly scale up on hover */
                    }

                </style>
                
            </form>
        </div>
    </div>
@endsection
