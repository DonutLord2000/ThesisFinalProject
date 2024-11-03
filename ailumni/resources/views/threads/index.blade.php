<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Discussion Area') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Create a new post</h3>
                <form action="{{ route('threads.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea name="content" id="content" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create post
                    </button>
                </form>

                <hr class="my-8" style="margin-bottom: 2rem; margin-top: 2rem;">

                <h3 class="text-lg font-semibold mb-4">Recent Discussion</h3>
                @foreach ($threads as $thread)
                    <div class="mb-4 p-4 border rounded-lg">
                        <h4 class="text-xl font-semibold">
                            <a href="{{ route('threads.show', $thread) }}" class="text-indigo-600 hover:text-indigo-800">{{ $thread->title }}</a>
                        </h4>
                        <p class="text-gray-600 text-sm">Posted by {{ $thread->user->name }} on {{ $thread->created_at->format('M d, Y') }}</p>
                        <p class="mt-2">{{ Str::limit($thread->content, 150) }}</p>
                        <div class="mt-2 text-sm text-gray-500">
                            <span>{{ $thread->upvotes }} upvotes</span>
                            <span class="ml-2">{{ $thread->hearts }} hearts</span>
                            <span class="ml-2">{{ $thread->comments_count }} comments</span>
                        </div>
                    </div>
                @endforeach

                {{ $threads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>