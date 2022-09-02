
<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @foreach ($years as $year => $articles)
        <div class="mt-12">
          <h2 class="text-bg leading-9 tracking-tight font-extrabold text-gray-900 border-b">
            {{ $year }}
          </h2>
            @foreach ($articles as $article)
            <div class="mt-6">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <div class="flex items-center">
                    <div class="flex-shrink-0">
                      <img class="h-10 w-10 rounded-full" src="{{ $article->user->profile() }}" alt="{{ $article->user->name }}" />
                    </div>
                    <div class="ml-4">
                      <div class="text-sm leading-5 font-medium text-gray-900">
                        {{ $article->user->name }}
                      </div>
                      <div class="text-sm leading-5 text-gray-500">
                        {{ $article->published_at->diffForHumans() }}
                      </div>
                    </div>
                  </div>
                  <div class="mt-2 text-base leading-6 text-gray-900">
                    {{ $article->title }}
                  </div>
                </div>
                <div class="mt-2 flex-shrink-0">
                  <a href="" class="text-indigo-600 hover:text-indigo-900">
                    {{ __('View') }}
                  </a>
                </div>
              </div>
              @endforeach
          </h2>
        </div>
        @endforeach
      </div>
  </div>
</x-app-layout>

