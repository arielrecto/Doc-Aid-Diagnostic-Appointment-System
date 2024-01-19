<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Username')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="w-full relative" x-data="{ showPassword: false }">
                <input type="password" name="password" x-bind:type="showPassword ? 'text' : 'password'"
                class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full' required autocomplete="new-password">
                <button @click.prevent="showPassword = !showPassword" class="btn btn-xs btn-ghost absolute top-2 right-1">
                    <i class="fi fi-rr-eye"></i>
                </button>
            </div>


            {{--
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" /> --}}

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <div class="flex flex-col gap-2">
                <p class="text-xs text-gray-500">At least one alphabetical character</p>
                <p class="text-xs text-gray-500">At least one digit</p>
                <p class="text-xs text-gray-500">At least one special character </p>
                <p class="text-xs text-gray-500">A minimum length of 8 characters</p>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />


            <div class="w-full relative" x-data="{ showPassword: false }">
                <input type="password"name="password_confirmation" x-bind:type="showPassword ? 'text' : 'password'"
                class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full' required autocomplete="new-password">
                <button @click.prevent="showPassword = !showPassword" class="btn btn-xs btn-ghost absolute top-2 right-1">
                    <i class="fi fi-rr-eye"></i>
                </button>
            </div>


            {{-- <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" /> --}}

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
