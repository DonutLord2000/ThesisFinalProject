@extends('layouts.alumni')

@section('content')

    <div>
        
        <div class="max-w-10rem mx-auto py-10 sm:px-6 lg:px-8" >
            <h1 class="text-center text-2xl font-semibold mb-6">Alumni List</h1>
            
            <div class="mx-auto" style="width: 70rem; display: flex; justify-content: flex-end;">
                
            </div>

            <div class="mb-4">
                <form method="GET" action="{{ route('alumni.profile.index') }}" class="flex mx-auto" style="width: 70rem;">
                    <input type="text" name="search" placeholder="Search by name or email..." class="border border-gray-300 rounded-full px-3 py-2 w-full" value="{{ request('search') }}">
                    <button type="submit" class="ml-2 bg-blue-500 text-white rounded-md px-4 py-2">Search</button>
                </form>
            </div>
                        
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mx-auto" style="width: 80rem;">
                            <table class="min-w-full divide-y divide-gray-200 w-full" style="width: 800px; table-layout: auto;">
                                <thead>
                                    <tr>
                                        <th scope="col" width="200" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('alumni.profile.index', ['sort' => 'name', 'direction' => $sortColumn === 'name' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                                                Name
                                                @if($sortColumn === 'name') 
                                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> 
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" width="150" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('alumni.profile.index', ['sort' => 'email', 'direction' => $sortColumn === 'email' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                                                Email
                                                @if($sortColumn === 'email') 
                                                    <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> 
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" width="150" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact Info
                                        </th>
                                        <th scope="col" width="150" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jobs
                                        </th>
                                        <th scope="col" width="200" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Achievements
                                        </th>
                                        <th scope="col" width="350" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Bio
                                        </th>
                                        <th scope="col" width="100" class="px-6 py-3 bg-gray-50"></th>
                                    </tr>
                                </thead>
                                
                                <tbody class="bg-white divide-y divide-gray-200" id="alumniTableBody">
                                    @include('alumni.partials.table_rows', ['alumni' => $alumni])
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script>
            document.querySelector('input[name="search"]').addEventListener('input', function() {
            const query = this.value;

            fetch(`{{ route('alumni.profile.index') }}?search=${query}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const tableRows = doc.querySelector('#alumniTableBody').innerHTML;
                    document.getElementById('alumniTableBody').innerHTML = tableRows;
                })
                .catch(error => console.error('Error fetching search results:', error));
                 });
        </script>

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
