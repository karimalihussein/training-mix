<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">id</th>
                            <th scope="col">title</th>
                            <th scope="col">description</th>
                            <th scope="col">image</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($articles as $article)
                         <tr>
                            <th scope="row">{{ $article->id }}</th>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->description }}</td>
                            <td>
                                <img src="{{ $article->image }}" alt="{{ $article->title }}" width="100">
                            </td>
                          </tr>
                          @endforeach
                
                
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
