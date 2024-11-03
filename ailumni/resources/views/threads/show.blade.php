<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $thread->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-2xl font-semibold mb-2">{{ $thread->title }}</h3>
                    <p class="text-gray-600 text-sm">Posted by {{ $thread->user->name }} on {{ $thread->created_at->format('M d, Y') }}</p>
                    <p class="mt-4">{{ $thread->content }}</p>
                    <div class="mt-4 flex items-center">
                        <button class="react-btn mr-4" data-type="upvote" data-thread="{{ $thread->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            <span class="upvote-count">{{ $thread->upvotes }}</span>
                        </button>
                        <button class="react-btn" data-type="heart" data-thread="{{ $thread->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="heart-count">{{ $thread->hearts }}</span>
                        </button>
                    </div>
                </div>

                <hr class="my-6">

                <h4 class="text-lg font-semibold mb-4">Comments</h4>
                @foreach ($thread->comments as $comment)
                    <div class="mb-4 p-4 border rounded-lg">
                        <p>{{ $comment->content }}</p>
                        <p class="text-gray-600 text-sm mt-2">Commented by {{ $comment->user->name }} on {{ $comment->created_at->format('M d, Y') }}</p>
                    </div>
                @endforeach

                <form action="{{ route('threads.comments.store', $thread) }}" method="POST" class="mt-6">
                    @csrf
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Add a comment</label>
                        <textarea name="content" id="content" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Post Comment
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.react-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const type = this.dataset.type;
                    const threadId = this.dataset.thread;

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
                        document.querySelector('.upvote-count').textContent = data.counts.upvotes;
                        document.querySelector('.heart-count').textContent = data.counts.hearts;
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>