<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @foreach ($users as $user)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="font-semibold text-xl">{{ $user->name }}</h1>
                        <div>{{ $user->posts_count }} {{ Str::plural('posts', $user->posts_count) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>