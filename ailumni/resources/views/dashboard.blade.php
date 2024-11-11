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
                        <div class="text-black-600">
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
                            <button id="monthlyBtn" class="px-4 py-2 bg-blue-100 text-white rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500">Monthly</button>
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
                    <h3 class="text-lg font-semibold mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Active Users Overview
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Daily Active Users -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-md hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-2 bg-blue-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex items-center text-sm text-blue-600">
                                    <span class="font-medium">Today</span>
                                </div>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-1">Daily Active Users</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl font-bold text-gray-900">{{ $dailyActiveUsers }}</span>
                                @if(isset($dailyActiveUsersGrowth))
                                    <div class="flex items-center {{ $dailyActiveUsersGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="{{ $dailyActiveUsersGrowth >= 0 
                                                    ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' 
                                                    : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                                        </svg>
                                        <span class="font-medium">{{ abs($dailyActiveUsersGrowth) }}%</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                
                        <!-- Weekly Active Users -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-md hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-2 bg-purple-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex items-center text-sm text-purple-600">
                                    <span class="font-medium">This Week</span>
                                </div>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-1">Weekly Active Users</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl font-bold text-gray-900">{{ $weeklyActiveUsers }}</span>
                                @if(isset($weeklyActiveUsersGrowth))
                                    <div class="flex items-center {{ $weeklyActiveUsersGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="{{ $weeklyActiveUsersGrowth >= 0 
                                                    ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' 
                                                    : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                                        </svg>
                                        <span class="font-medium">{{ abs($weeklyActiveUsersGrowth) }}%</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                
                        <!-- Monthly Active Users -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-md hover:shadow-md transition-shadow duration-300">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-2 bg-green-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div class="flex items-center text-sm text-green-600">
                                    <span class="font-medium">This Month</span>
                                </div>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-1">Monthly Active Users</h4>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl font-bold text-gray-900">{{ $monthlyActiveUsers }}</span>
                                @if(isset($monthlyActiveUsersGrowth))
                                    <div class="flex items-center {{ $monthlyActiveUsersGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="{{ $monthlyActiveUsersGrowth >= 0 
                                                    ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' 
                                                    : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                                        </svg>
                                        <span class="font-medium">{{ abs($monthlyActiveUsersGrowth) }}%</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- NEws post -->
            <div class="mt-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Latest News</h2>
                @foreach ($newsPosts as $post)
                    <div class="mb-8 relative border-l-4 border-l-gray-600 bg-white shadow-md rounded-lg overflow-hidden mx-auto" style="width: 70rem">
                        <div class="absolute left-2 top-2 text-black-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 " viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="bg-gray-200 text-black py-2 px-4 flex items-center justify-between">
                            <h3 class="ml-2 font-semibold">{{ $post->title }}</h3>
                        </div>
                        <div class="p-4 pl-12">
                            @if($post->image)
                                    <img src="{{ Storage::url($post->image) }}" alt="News post image" class="mb-2 mt-2 mr-4 rounded-lg" style="max-width: 40rem; max-height: 24rem; object-contain;">
                            @endif
                            @if($post->video)
                                <video controls class="w-full h-auto mb-4 rounded-lg">
                                    <source src="{{ Storage::url($post->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                            <div class="prose prose-sm max-w-none mb-2 mt-2 mr-4">
                                {!! nl2br(e($post->content)) !!}
                            </div>
                        </div>
                        @if($post->source)
                            <div class="px-4 py-2 text-sm text-black-600 border-t">
                                This is a message from <strong>{{ $post->source }}</strong>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            </div>
        </div>
        </div>
    </div>

    @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
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
    updateRegistrationsChart('monthly');

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
                borderWidth: 1
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
                },
                datalabels: {
                    color: '#000',
                    font: {
                        weight: 'bold'
                    },
                    formatter: function(value, context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(1);
                        return `${percentage}%`;
                    }
                }
            }
        },
        plugins: [ChartDataLabels]  // Enable the datalabels plugin
        });
});
</script>
@endpush
</x-app-layout>