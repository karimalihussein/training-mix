<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach ($posts as $post)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                  
                        <div>{{ $post->user->name }}</div>
                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                            {{ $post->active == '1' ? 'Active' : 'Inactive' }}
                        </div>
                        <a href="{{ route('posts.show', $post) }}"><h1 class="font-semibold text-xl mt-2">{{ $post->title }} - {{ $post->created_at->diffForHumans() }}</h1></a>
                        <p class="mt-2">{{ $post->content }}</p>
                    </div>
                </div>
            @endforeach
            <br>
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>