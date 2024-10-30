<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-blue-100 p-6 rounded-lg shadow-md flex items-center">
                        <div class="text-blue-600 mr-4">
                            <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Total Users</h3>
                            <p class="text-2xl">{{ $totalUsers }}</p>
                        </div>
                    </div>

                    <div class="bg-blue-100 p-6 rounded-lg shadow-md flex items-center">
                        <div class="text-blue-800 mr-4">
                            <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Total Students</h3>
                            <p class="text-2xl">{{ $studentsCount }}</p>
                        </div>
                    </div>

                    <div class="bg-green-100 p-6 rounded-lg shadow-md flex items-center">
                        <div class="text-green-600 mr-4">
                            <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Total Alumni</h3>
                            <p class="text-2xl">{{ $alumniCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
