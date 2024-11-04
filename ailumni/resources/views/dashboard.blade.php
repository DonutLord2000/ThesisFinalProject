<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-100 p-6 rounded-lg shadow-md flex items-center justify-between h-40">
                        <div class="text-blue-600">
                            <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <h3 class="text-lg font-semibold">Total Users</h3>
                            <p class="text-2xl">{{ $totalUsers }}</p>
                            <p class="text-sm text-gray-600">+{{ $newUsersThisMonth }} this month</p>
                        </div>
                    </div>

                    <div class="bg-blue-100 p-6 rounded-lg shadow-md flex items-center justify-between h-40">
                        <div class="text-blue-600">
                            <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <h3 class="text-lg font-semibold">Registered Students</h3>
                            <p class="text-2xl">{{ $studentsCount }}</p>
                            <p class="text-sm text-gray-600">+{{ $newStudentsThisMonth }} this month</p>
                        </div>
                    </div>

                    <div class="bg-green-100 p-6 rounded-lg shadow-md flex items-center justify-between h-40">
                        <div class="text-green-600">
                            <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <h3 class="text-lg font-semibold">Registered Alumni</h3>
                            <p class="text-2xl">{{ $alumniCount }}</p>
                            <p class="text-sm text-gray-600">{{ $employmentRate }}% employed</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-4">Monthly User Registrations</h3>
                        <canvas id="monthlyRegistrationsChart"></canvas>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-4">Alumni Employment Rate</h3>
                        <canvas id="alumniEmploymentChart"></canvas>
                    </div>
                </div>

                <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Active Users Overview</h3>
                    <div class="flex space-x-4">
                        <div class="flex-1 bg-gray-100 p-4 rounded-lg">
                            <h4 class="text-md font-semibold">Daily Active Users</h4>
                            <p class="text-2xl font-bold">{{ $dailyActiveUsers }}</p>
                        </div>
                        <div class="flex-1 bg-gray-100 p-4 rounded-lg">
                            <h4 class="text-md font-semibold">Weekly Active Users</h4>
                            <p class="text-2xl font-bold">{{ $weeklyActiveUsers }}</p>
                        </div>
                        <div class="flex-1 bg-gray-100 p-4 rounded-lg">
                            <h4 class="text-md font-semibold">Monthly Active Users</h4>
                            <p class="text-2xl font-bold">{{ $monthlyActiveUsers }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Registrations Chart
        var monthlyCtx = document.getElementById('monthlyRegistrationsChart').getContext('2d');
        var monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: 'New Registrations',
                    data: @json($monthlyData),
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Alumni Employment Rate Chart
        var alumniCtx = document.getElementById('alumniEmploymentChart').getContext('2d');
        var alumniChart = new Chart(alumniCtx, {
            type: 'bar',
            data: {
                labels: @json($employmentLabels),
                datasets: [{
                    label: 'Employment Rate (%)',
                    data: @json($employmentData),
                    backgroundColor: 'rgba(16, 185, 129, 0.6)',
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>