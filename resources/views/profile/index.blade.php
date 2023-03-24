<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if ($errors->any())
         <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                @endforeach
              </ul>
         </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                   <form action="{{ route('profile.update-password') }}" method="POST">
                    @csrf
                    <div>
                        <x-label for="current_password" :value="__('Current Password')" />

                        <x-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" required />
                        @if ($errors->has('current_password'))
                            <span class="text-red-500">{{ $errors->first('current_password') }}</span>
                        @endif
                    </div>
                    <div>
                        <x-label for="password" :value="__('New Password')" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus />
                    </div>

                    <div>
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Update Password') }}
                        </x-button>
                   </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
