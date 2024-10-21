@extends('layouts.admin')

@section('content')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User List
        </h2>
    </x-slot>

    <div>
        <div class="max-w-10rem mx-auto py-10 sm:px-6 lg:px-8" >
            <div class="mx-auto" style="width: 70rem;">
                <a href="{{ route('admin.users.create') }}" class="flex items-center justify-center w-full px-4 py-4 text-sm font-bold leading-6 capitalize duration-100 transform border-2 rounded-sm cursor-pointer border-green-300 focus:ring-4 focus:ring-green-500 focus:ring-opacity-50 focus:outline-none sm:w-auto sm:px-6 border-text  hover:shadow-lg hover:-translate-y-1">Add User</a>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mx-auto" style="width: 70rem;">
                            <table class="min-w-full divide-y divide-gray-200 w-full" style="width: 800px; table-layout: auto;">
                                <thead>
                                <tr>
                                    <th scope="col" width="250" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" width="400"class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" width="150" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th scope="col" width="150" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student ID
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
                                                <span class="inline-block px-2 py-1 bg-red-500 text-red-800 rounded">
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
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2" value="Delete">
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
    </div>

@endsection
