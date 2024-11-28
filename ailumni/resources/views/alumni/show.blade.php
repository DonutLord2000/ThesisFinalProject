<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alumnus Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Personal Information</h3>
                            <p><strong>Name:</strong> {{ $alumnus->name }}</p>
                            <p><strong>Year of Graduation:</strong> {{ $alumnus->year_graduated }}</p>
                            <p><strong>Age:</strong> {{ $alumnus->age ?? 'N/A' }}</p>
                            <p><strong>Gender:</strong> {{ $alumnus->gender ?? 'N/A' }}</p>
                            <p><strong>Marital Status:</strong> {{ $alumnus->marital_status ?? 'N/A' }}</p>
                            <p><strong>Current Location:</strong> {{ $alumnus->current_location ?? 'N/A' }}</p>
                            <p><strong>Email Address:</strong> {{ $alumnus->email ?? 'N/A' }}</p>
                            <p><strong>Phone Number:</strong> {{ $alumnus->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Academic Information</h3>
                            <p><strong>Degree Program:</strong> {{ $alumnus->degree_program }}</p>
                            <p><strong>Major:</strong> {{ $alumnus->major ?? 'N/A' }}</p>
                            <p><strong>Minor:</strong> {{ $alumnus->minor ?? 'N/A' }}</p>
                            <p><strong>Overall GPA:</strong> {{ $alumnus->gpa ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Employment Information</h3>
                        <p><strong>Employment Status:</strong> {{ $alumnus->employment_status ?? 'N/A' }}</p>
                        <p><strong>Job Title:</strong> {{ $alumnus->job_title ?? 'N/A' }}</p>
                        <p><strong>Company/Organization:</strong> {{ $alumnus->company ?? 'N/A' }}</p>
                        <p><strong>Industry:</strong> {{ $alumnus->industry ?? 'N/A' }}</p>
                        <p><strong>Nature of Work:</strong> {{ $alumnus->nature_of_work ?? 'N/A' }}</p>
                        <p><strong>Employment Sector:</strong> {{ $alumnus->employment_sector ?? 'N/A' }}</p>
                        <p><strong>Tenure Status:</strong> {{ $alumnus->tenure_status ?? 'N/A' }}</p>
                        <p><strong>Monthly Salary:</strong> {{ $alumnus->monthly_salary ? '$' . number_format($alumnus->monthly_salary, 2) : 'N/A' }}</p>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('alumni.edit', $alumnus) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <button onclick="confirmDelete()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this alumnus?')) {
                fetch('{{ route('alumni.destroy', $alumnus) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        window.location.href = '{{ route('alumni.index') }}';
                    }
                });
            }
        }
    </script>
</x-app-layout>