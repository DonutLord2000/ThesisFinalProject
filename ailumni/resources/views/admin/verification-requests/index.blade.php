<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verification Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        @foreach($verificationRequests as $request)
                            <div class="bg-white rounded-lg shadow p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $request->user->profile?->profile_picture ? Storage::url($request->user->profile->profile_picture) : $request->user->profile_photo_url }}"
                                             class="w-12 h-12 rounded-full"
                                             alt="{{ $request->user->name }}">
                                        <div>
                                            <h3 class="text-lg font-medium">{{ $request->user->name }}</h3>
                                            <p class="text-sm text-gray-500">Submitted: {{ $request->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ Storage::url($request->document_path) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                            View Document
                                        </a>
                                        <form action="{{ route('admin.verification-requests.review', $request) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <x-button type="submit" class="bg-green-600 hover:bg-green-700">
                                                Approve
                                            </x-button>
                                        </form>
                                        <form action="{{ route('admin.verification-requests.review', $request) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <x-button type="submit" class="bg-red-600 hover:bg-red-700">
                                                Reject
                                            </x-button>
                                        </form>
                                    </div>
                                </div>
                                @if($request->admin_notes)
                                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-gray-600">{{ $request->admin_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $verificationRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>