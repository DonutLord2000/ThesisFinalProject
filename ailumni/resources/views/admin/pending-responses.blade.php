@extends('layouts.alumni')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-center text-3xl font-bold mb-8 text-gray-800">Pending Responses</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="mb-6 px-4">
            <form id="searchForm" action="{{ route('admin.pending-responses') }}" method="GET" class="flex">
                <input 
                    type="text" 
                    id="searchInput" 
                    name="search" 
                    placeholder="Search responses..." 
                    class="border border-gray-300 rounded-full px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('search') }}"
                >
            </form>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300" id="pendingResponsesTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Year Graduated</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Degree Program</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($pendingResponses as $response)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $response->id }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $response->response_data['name'] ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $response->response_data['year_graduated'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $response->response_data['degree_program'] }}</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <button class="text-blue-600 hover:text-blue-900 mr-2 view-details" data-id="{{ $response->id }}">View</button>
                                            <button class="text-green-600 hover:text-green-900 mr-2 edit-response" data-id="{{ $response->id }}">Edit</button>
                                            <form action="{{ route('admin.approve', $response) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.reject', $response) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
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

        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Processed Responses</h2>
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Year Graduated</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Degree Program</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($processedResponses as $response)
                                    <tr class="{{ $response->status === 'approved' ? 'bg-green-300' : 'bg-red-300' }}">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $response->id }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-black-500">{{ $response->response_data['name'] ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-black-500">{{ $response->response_data['year_graduated'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-black-500">{{ $response->response_data['degree_program'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-black-500">{{ ucfirst($response->status) }}</td>
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

<!-- Modal for viewing response details -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="responseDetailsModal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="responseDetailsModalLabel">
                            Response Details
                        </h3>
                        <div class="mt-2">
                            <div id="responseDetailsContent"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closeResponseDetailsModal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing response -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="editResponseModal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="editResponseModalLabel">
                            Edit Response
                        </h3>
                        <div class="mt-2">
                            <form id="editResponseForm">
                                @csrf
                                <input type="hidden" id="editResponseId" name="id">
                                <!-- Form fields will be loaded dynamically -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" id="saveEditResponse">
                    Save changes
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closeEditResponseModal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-details');
    const editButtons = document.querySelectorAll('.edit-response');
    const responseDetailsModal = document.getElementById('responseDetailsModal');
    const editResponseModal = document.getElementById('editResponseModal');
    const closeResponseDetailsModal = document.getElementById('closeResponseDetailsModal');
    const closeEditResponseModal = document.getElementById('closeEditResponseModal');
    const saveEditResponse = document.getElementById('saveEditResponse');

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const responseId = this.getAttribute('data-id');
            fetch(`/admin/pending-responses/${responseId}`)
                .then(response => response.json())
                .then(data => {
                    let content = '<dl class="space-y-2">';
                    for (const [key, value] of Object.entries(data.response_data)) {
                        content += `<div class="flex flex-col sm:flex-row"><dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">${key.replace(/_/g, ' ').charAt(0).toUpperCase() + key.replace(/_/g, ' ').slice(1)}</dt>`;
                        content += `<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:ml-6 sm:col-span-2">${value}</dd></div>`;
                    }
                    content += '</dl>';
                    document.getElementById('responseDetailsContent').innerHTML = content;
                    responseDetailsModal.classList.remove('hidden');
                });
        });
    });

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const responseId = this.getAttribute('data-id');
            fetch(`/admin/pending-responses/${responseId}/edit`)
                .then(response => response.json())
                .then(data => {
                    let content = '';
                    for (const [key, value] of Object.entries(data.response_data)) {
                        content += `
                            <div class="mb-4">
                                <label for="${key}" class="block text-sm font-medium text-gray-700">${key.replace(/_/g, ' ').charAt(0).toUpperCase() + key.replace(/_/g, ' ').slice(1)}</label>
                                <input type="text" id="${key}" name="${key}" value="${value}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        `;
                    }
                    document.getElementById('editResponseForm').innerHTML = content;
                    document.getElementById('editResponseId').value = responseId;
                    editResponseModal.classList.remove('hidden');
                });
        });
    });

    closeResponseDetailsModal.addEventListener('click', function() {
        responseDetailsModal.classList.add('hidden');
    });

    closeEditResponseModal.addEventListener('click', function() {
        editResponseModal.classList.add('hidden');
    });

    saveEditResponse.addEventListener('click', function() {
        const form = document.getElementById('editResponseForm');
        const formData = new FormData(form);
        const responseId = document.getElementById('editResponseId').value;

        fetch(`/admin/pending-responses/${responseId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                editResponseModal.classList.add('hidden');
                location.reload(); // Reload the page to show updated data
            } else {
                alert('Error updating response');
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
    .max-w-7xl {
        max-width: 95% !important;
    }

    #pendingResponsesTable {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    #pendingResponsesTable th {
        position: sticky;
        top: 0;
        background: #f3f4f6;
        z-index: 10;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
    }

    #pendingResponsesTable th, #pendingResponsesTable td {
        border-right: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    #pendingResponsesTable th:first-child, #pendingResponsesTable td:first-child {
        border-left: 1px solid #e5e7eb;
    }

    #pendingResponsesTable tr:first-child th {
        border-top: 1px solid #e5e7eb;
    }

    #pendingResponsesTable tr:last-child td {
        border-bottom: none;
    }

    #pendingResponsesTable th:first-child {
        border-top-left-radius: 0.5rem;
    }

    #pendingResponsesTable th:last-child {
        border-top-right-radius: 0.5rem;
    }

    #pendingResponsesTable tr:last-child td:first-child {
        border-bottom-left-radius: 0.5rem;
    }

    #pendingResponsesTable tr:last-child td:last-child {
        border-bottom-right-radius: 0.5rem;
    }

    tbody tr:hover {
        background-color: #f9fafb;
    }
</style>
@endpush
</ReactProject>
