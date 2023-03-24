<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

   {{--  if there is any errors  --}}


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div>
                        <!-- check if the has any errors -->
                    </div>
                    <div>
                        <x-label for="app_name" :value="__('App Name')" />
                        <x-input id="app_name" class="block mt-1 w-full" type="text" name="app_name" required autofocus value="{{ $values['app_name'] }}" />
                    </div>
                    
                    <!-- supported_languages select-box for all lang -->
                    <div class="mt-4">
                        <x-label for="supported_languages" :value="__('Supported Languages')" />
                        <select name="supported_languages[]" id="supported_languages" class="block mt-1 w-full" multiple>
                            @foreach (config('localized-routes') as $key => $locale)
                                <option value="{{ $$key  }}" {{ in_array($$key , $values['supported_languages']) ? 'selected' : '' }}>{{ $$key  }}</option>
                            @endforeach
                        </select>



                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Update') }}
                        </x-button>
                   </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
