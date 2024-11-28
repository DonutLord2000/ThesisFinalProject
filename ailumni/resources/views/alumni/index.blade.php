<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alumni List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Degree Program</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employment Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year Graduated</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($alumni as $alumnus)
                                <tr class="hover:bg-gray-100 cursor-pointer" onclick="window.location='{{ route('alumni.show', $alumnus) }}'">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $alumnus->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $alumnus->gender ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $alumnus->degree_program }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $alumnus->employment_status ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $alumnus->year_graduated }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button onclick="event.stopPropagation(); confirmDelete({{ $alumnus->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this alumnus?')) {
                fetch(`/alumni/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            }
        }
    </script>
</x-app-layout>