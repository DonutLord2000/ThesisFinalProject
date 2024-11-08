@extends('layouts.alumni')

@section('content')
<div>
    <div class="max-w-10rem mx-auto py-10 sm:px-6 lg:px-8">
        <h1 class="text-center text-2xl font-semibold mb-6">Alumni List</h1>
        
        <div class="mx-auto" style="width: 70rem; display: flex; justify-content: flex-end;"></div>

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
                        <table class="min-w-full divide-y divide-gray-200 w-full" style="table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 15%;">
                                        <a href="{{ route('alumni.profile.index', ['sort' => 'name', 'direction' => $sortColumn === 'name' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                                            Name
                                            @if($sortColumn === 'name') 
                                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> 
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 15%;">
                                        <a href="{{ route('alumni.profile.index', ['sort' => 'email', 'direction' => $sortColumn === 'email' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                                            Email
                                            @if($sortColumn === 'email') 
                                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> 
                                            @endif
                                        </a>
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 12%;">
                                        Contact Info
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 15%;">
                                        Jobs
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 15%;">
                                        Achievements
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 20%;">
                                        Bio
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50" style="width: 7%;"></th>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let page = 1;
        let loading = false;
        
        function loadMoreAlumni() {
            if (loading) return;
            loading = true;
            
            $.ajax({
                url: '{{ route('alumni.profile.index') }}',
                data: {
                    page: page + 1,
                    search: $('input[name="search"]').val(),
                    sort: '{{ $sortColumn }}',
                    direction: '{{ $sortDirection }}'
                },
                success: function(data) {
                    if (data.trim() !== '') {
                        $('#alumniTableBody').append(data);
                        page++;
                        loading = false;
                    }
                }
            });
        }

        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                loadMoreAlumni();
            }
        });

        $('input[name="search"]').on('input', function() {
            const query = $(this).val();
            page = 1;

            $.ajax({
                url: '{{ route('alumni.profile.index') }}',
                data: { search: query },
                success: function(data) {
                    $('#alumniTableBody').html(data);
                }
            });
        });
    </script>

    <style>
        .btn-custom {
            background-color: #ff6b6b;
            color: white;
            font-weight: 600;
            padding: 0.5rem;
            border-radius: 0.375rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin-bottom: 1rem;
        }
    
        .btn-custom:hover {
            background-color: #ff4d4d;
            transform: scale(1.05);
        }

        td {
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 1px;
        }
    </style>
</div>
@endsection