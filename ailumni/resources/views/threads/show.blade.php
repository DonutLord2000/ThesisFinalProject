<x-app-layout>
    

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6 mx-auto" style="width: 70rem">
                <div class="p-6">
                    <div class="flex items-start space-x-3">
                        <img src="{{ $thread->user->profile_photo_url }}" alt="{{ $thread->user->name }}" class="w-12 h-12 rounded-full">
                        <div class="flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $thread->user->name }}
                                @php
                                $bgColor = match($thread->user->role) {
                                    'alumni' => 'inline-block px-2 py-1 bg-green-500 text-green-800 rounded',
                                                'admin' => 'text-white inline-block px-2 py-1 bg-red-500 text-red-800 rounded',
                                                'student' => 'inline-block px-2 py-1 bg-blue-500 text-blue-800 rounded',
                                    default => 'bg-gray-200 text-gray-700',
                                    };
                                @endphp

                                <span class="text-sm font-normal {{ $bgColor }} px-2 py-1 rounded-full ml-2">
                                    {{ $thread->user->role }}
                                </span>

                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ $thread->created_at->format('M d, Y h:i A') }}
                            </p>
                            <p class="mt-4 text-gray-700 text-lg">{{ $thread->content }}</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
                    <div class="flex space-x-4">
                        <button class="react-btn flex items-center space-x-1 text-gray-500 hover:text-blue-500 transition-colors duration-200" data-type="upvote" data-thread="{{ $thread->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                            <span class="upvote-count">{{ $thread->upvotes }}</span>
                        </button>
                        <button class="ml-2 react-btn flex items-center space-x-1 text-gray-500 hover:text-pink-500 transition-colors duration-200" data-type="heart" data-thread="{{ $thread->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="heart-count">{{ $thread->hearts }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <h4 class="text-center mx-auto text-2xl font-bold mb-4 text-gray-900">Comments</h4>
            <div class="space-y-4 mb-6">
                @foreach ($thread->comments as $comment)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shadow-xl mx-auto mb-2" style="width: 70rem">
                        <div class="p-6">
                            <div class="flex items-start space-x-3">
                                <img src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full">
                                <div class="flex-grow">
                                    <p class="font-semibold text-gray-900">
                                        {{ $comment->user->name }}
                                        @php
                                            $bgColor = match($comment->user->role) {
                                                'alumni' => 'inline-block px-2 py-1 bg-green-500 text-green-800 rounded',
                                                'admin' => 'text-white inline-block px-2 py-1 bg-red-500 text-red-800 rounded',
                                                'student' => 'inline-block px-2 py-1 bg-blue-500 text-blue-800 rounded',
                                                default => 'bg-gray-200 text-gray-700',
                                            };
                                        @endphp

                                        <span class="text-xs {{ $bgColor }} px-2 py-1 rounded-full ml-2">
                                            {{ $comment->user->role }}
                                        </span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->format('M d, Y h:i A') }}</p>
                                    <p class="text-sm text-gray-700 mt-2">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shadow-xl mx-auto" style="width: 70rem">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Add a comment</h3>
                    <form action="{{ route('threads.comments.store', $thread) }}" method="POST">
                        @csrf
                        <div class="flex items-start space-x-3">
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full mr-2">
                                <input type="text" name="content" placeholder="Write a comment..." class="flex-grow border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border rounded-md mr-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Post
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function updateButtonState(button, isReacted) {
            const type = button.dataset.type;
            const icon = button.querySelector('svg');
            
            if (isReacted) {
                icon.style.color = type === 'upvote' ? "blue" : "red";
            } else {
                icon.style.color = "gray";
            }
        }

        document.querySelectorAll('.react-btn').forEach(button => {
            const type = button.dataset.type;
            const threadId = button.dataset.thread;
            const countSpan = button.querySelector(`.${type}-count`);

            // Set initial state
            fetch(`/threads/${threadId}/reaction-status`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                updateButtonState(button, data[type]);
            })
            .catch(error => console.error('Error:', error));

            // Add click event listener
            button.addEventListener('click', function() {
                fetch(`/threads/${threadId}/react`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ type: type })
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.counts) {
                        document.querySelector('.upvote-count').textContent = data.counts.upvotes;
                        document.querySelector('.heart-count').textContent = data.counts.hearts;

                        // Update button states
                        document.querySelectorAll('.react-btn').forEach(btn => {
                            const btnType = btn.dataset.type;
                            updateButtonState(btn, data.userReacted[btnType]);
                        });

                        // Add a subtle animation
                        countSpan.classList.add('scale-125');
                        setTimeout(() => countSpan.classList.remove('scale-125'), 200);
                    } else {
                        console.error('Unexpected response format:', data);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endpush
</x-app-layout>