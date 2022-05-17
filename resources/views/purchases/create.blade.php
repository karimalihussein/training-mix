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
                   


                    <form method="POST" action="{{ route('purchases.store') }}">
                        @csrf
            
                        <!-- Name -->
                        <div>
                            <x-label for="first_name" :value="__('first_name')" />
            
                            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                        </div>

                        <div>
                            <x-label for="last_name" :value="__('last_name')" />
            
                            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
                        </div>

                        <div>
                            <x-label for="email" :value="__('email')" />
            
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        </div>

                        <div>
                            <x-label for="city" :value="__('city')" />
            
                            <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autofocus />
                        </div>


                        <div>
                            <x-label for="address" :value="__('address')" />
            
                            <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus />
                        </div>

                        <div>
                            <x-label for="zip_code" :value="__('zip_code')" />
            
                            <x-input id="zip_code" class="block mt-1 w-full" type="number" name="zip_code" :value="old('zip_code')" required autofocus />
                        </div>

                 
            
              
                    
            
            
                        <div class="flex items-center justify-end mt-4">
                     
            
                            <x-button class="ml-4">
                                {{ __('submit') }}
                            </x-button>
                        </div>
                    </form>












                </div>
            </div>
        </div>
    </div>
</x-app-layout>
