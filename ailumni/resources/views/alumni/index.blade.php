<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alumni List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold mb-2">Show/Hide Columns:</h3>
                    <div class="flex flex-wrap gap-4">
                        @php
                            $additionalColumns = [
                                'marital_status' => 'Marital Status',
                                'email' => 'Email',
                                'phone' => 'Phone',
                                'major' => 'Major',
                                'minor' => 'Minor',
                                'gpa' => 'GPA',
                                'job_title' => 'Job Title',
                                'company' => 'Company',
                                'nature_of_work' => 'Nature of Work',
                                'tenure_status' => 'Tenure Status',
                                'monthly_salary' => 'Monthly Salary'
                            ];
                        @endphp
                        @foreach($additionalColumns as $column => $label)
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox column-toggle" name="{{ $column }}" value="{{ $column }}">
                                <span class="ml-2">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-6">
                <div class="p-6">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="alumniTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Degree Program</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employment Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Industry</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year Graduated</th>
                                    @foreach($additionalColumns as $column => $label)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider column-{{ $column }} hidden">{{ $label }}</th>
                                    @endforeach
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
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $alumnus->industry ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $alumnus->year_graduated }}</td>
                                        @foreach($additionalColumns as $column => $label)
                                            <td class="px-6 py-4 whitespace-nowrap column-{{ $column }} hidden">{{ $alumnus->$column ?? 'N/A' }}</td>
                                        @endforeach
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

        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('alumniTable');
            const toggles = document.querySelectorAll('.column-toggle');

            toggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const column = this.value;
                    const cells = table.querySelectorAll(`.column-${column}`);
                    cells.forEach(cell => {
                        cell.classList.toggle('hidden');
                    });
                    adjustTableSize();
                });
            });

            function adjustTableSize() {
                const visibleColumns = document.querySelectorAll('th:not(.hidden)').length;
                const baseSize = 14; // Base font size in pixels
                const minSize = 14; // Minimum font size in pixels
                let newSize = Math.max(baseSize - (visibleColumns - 7), minSize);
                table.style.fontSize = `${newSize}px`;
            }
        });
    </script>
</x-app-layout>

