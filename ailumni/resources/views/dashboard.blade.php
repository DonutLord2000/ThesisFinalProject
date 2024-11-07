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
                        <h3 class="text-lg font-semibold mb-4">User Registrations</h3>
                        <div class="mb-4 flex space-x-2">
                            <button id="dailyBtn" class="px-4 py-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500">Daily</button>
                            <button id="monthlyBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Monthly</button>
                            <button id="yearlyBtn" class="px-4 py-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500">Yearly</button>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="userRegistrationsChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-4">Alumni Employment Rate</h3>
                        <div style="height: 300px;">
                            <canvas id="alumniEmploymentChart"></canvas>
                        </div>
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
                        <div class="flex-1 bg-gray-100 p-4 rounded-lg" style="">
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
document.addEventListener('DOMContentLoaded', function() {
    // User Registrations Chart
    var registrationsCtx = document.getElementById('userRegistrationsChart').getContext('2d');
    var registrationsChart;

    function updateRegistrationsChart(period) {
        if (registrationsChart) {
            registrationsChart.destroy();
        }

        var data = {
            daily: @json($dailyRegistrations),
            monthly: @json($monthlyRegistrations),
            yearly: @json($yearlyRegistrations)
        };

        // Update button styles
        document.querySelectorAll('[id$="Btn"]').forEach(btn => {
            btn.classList.remove('bg-blue-500', 'text-white');
            btn.classList.add('bg-blue-100', 'text-blue-600');
        });
        document.getElementById(period + 'Btn').classList.remove('bg-blue-100', 'text-blue-600');
        document.getElementById(period + 'Btn').classList.add('bg-blue-500', 'text-white');

        // Convert data for scatter plot
        const scatterData = data[period].data.map((value, index) => ({
            x: index,
            y: value
        }));

        registrationsChart = new Chart(registrationsCtx, {
            type: 'scatter',
            data: {
                labels: data[period].labels,
                datasets: [{
                    label: 'User Registrations',
                    data: scatterData,
                    backgroundColor: 'rgb(59, 130, 246)',
                    borderColor: 'rgb(59, 130, 246)',
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    showLine: true,
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${data[period].labels[context.dataIndex]}: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        type: 'category',
                        labels: data[period].labels,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    // Initialize with monthly data
    updateRegistrationsChart('daily');

    // Event listeners for period buttons
    document.getElementById('dailyBtn').addEventListener('click', () => updateRegistrationsChart('daily'));
    document.getElementById('monthlyBtn').addEventListener('click', () => updateRegistrationsChart('monthly'));
    document.getElementById('yearlyBtn').addEventListener('click', () => updateRegistrationsChart('yearly'));

    // Alumni Employment Rate Pie Chart
    var alumniCtx = document.getElementById('alumniEmploymentChart').getContext('2d');
    var alumniChart = new Chart(alumniCtx, {
        type: 'pie',
        data: {
            labels: ['Employed', 'Unemployed', 'Unknown'],
            datasets: [{
                data: @json($employmentData),
                backgroundColor: [
                    'rgba(16, 185, 129, 0.6)',  // Green
                    'rgba(239, 68, 68, 0.6)',   // Red
                    'rgba(107, 114, 128, 0.6)'  // Gray
                ],
                borderColor: [
                    'rgb(16, 185, 129)',
                    'rgb(239, 68, 68)',
                    'rgb(107, 114, 128)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ${percentage}% (${value})`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
</x-app-layout>