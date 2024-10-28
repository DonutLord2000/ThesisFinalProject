@extends('layouts.admin')

@section('content')

    <div>
        
        <div class="max-w-10rem mx-auto py-10 sm:px-6 lg:px-8" >
            <h1 class="text-center text-2xl font-semibold mb-6">User List</h1>
            
            <div class="mx-auto" style="width: 70rem; display: flex; justify-content: flex-end;">
                <a href="{{ route('admin.users.create') }}" class="btn-custom">
                    Add User
                </a>
            </div>

            <div class="mb-4">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex mx-auto" style="width: 70rem;">
                    <input type="text" name="search" placeholder="Search by name, email, or student ID..." class="border border-gray-300 rounded-full px-3 py-2 w-full" value="{{ request('search') }}">
                    <button type="submit" class="ml-2 bg-blue-500 text-white rounded-md px-4 py-2">Search</button>
                </form>
            </div>
                        
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mx-auto" style="width: 70rem;">
                            <table class="min-w-full divide-y divide-gray-200 w-full" style="width: 800px; table-layout: auto;">
                                <thead>
                                    <tr>
                                        <th scope="col" width="250" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('admin.users.index', ['sort' => 'name', 'direction' => $sortColumn === 'name' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Name
                                                @if($sortColumn === 'name') 
                                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> 
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" width="400" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('admin.users.index', ['sort' => 'email', 'direction' => $sortColumn === 'email' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Email
                                                @if($sortColumn === 'email') 
                                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> 
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" width="150" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('admin.users.index', ['sort' => 'role', 'direction' => $sortColumn === 'role' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Role
                                                @if($sortColumn === 'role') 
                                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> 
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" width="150" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('admin.users.index', ['sort' => 'student_id', 'direction' => $sortColumn === 'student_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Student ID
                                                @if($sortColumn === 'student_id') 
                                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> 
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" width="200" class="px-6 py-3 bg-gray-50">
                                        </th>
                                    </tr>
                                </thead>
                                
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $user->name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $user->email }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($user->role == 'student')
                                                <span class="inline-block px-2 py-1 bg-blue-500 text-blue-800 rounded">
                                                    {{ $user->role }}
                                                </span>
                                            @elseif($user->role == 'alumni')
                                                <span class="inline-block px-2 py-1 bg-green-500 text-green-800 rounded">
                                                    {{ $user->role }}
                                                </span>
                                            @elseif($user->role == 'admin')
                                                <span class="text-white inline-block px-2 py-1 bg-red-500 text-red-800 rounded">
                                                    {{ $user->role }}
                                                </span>                                         
                                            @endif
                                        </td>
                                        
                                
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $user->student_id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 mb-2 mr-2">Edit</a>
                                            <form class="inline-block" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE') <!-- This will handle the DELETE request -->
                                                
                                                <button type="submit" class="text-red-600 hover:text-red-900 focus:outline-none px-4 py-2 rounded-md mb-2 mr-2">
                                                    Delete
                                                </button>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <style>
            .btn-custom {
                background-color: #ff6b6b; /* Light red */
                color: white; /* Text color */
                font-weight: 600; /* Semi-bold */
                padding: 0.5rem; /* Vertical padding */
                border-radius: 0.375rem; /* Rounded corners */
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
                transition: background-color 0.3s, transform 0.3s;
                display: inline-flex; /* Center text within the button */
                align-items: center; /* Vertically center text */
                justify-content: center; /* Horizontally center text */
                text-decoration: none; /* Remove underline */
                margin-bottom: 1rem;
            }
        
            .btn-custom:hover {
                background-color: #ff4d4d; /* Darker shade on hover */
                transform: scale(1.05); /* Slightly scale up on hover */
            }
        </style>
    </div>

@endsection
