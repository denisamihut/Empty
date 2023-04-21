<x-guest-layout>
    <div class="h-screen flex sm:justify-center items-center bg-white">
        <x-auth-image />
        <x-auth-card>
            <x-slot name="logo">
                <a href="/">
                    <x-application-logo />
                </a>
            </x-slot>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <p class="font-baloo font-extrabold text-lg text-center text-blue-corp">{{ __('auth.title') }}</p>
            <form method="POST" action="{{ route('login') }}" class="py-5">
                @csrf
                <!-- Email Address -->
                <div>
                    <x-label for="email" class="text-base font-medium" :value="__('auth.email')" />
                    <x-input id="email" class="block mt-2 w-full py-1.5 text-[0.9rem]" :placeholder="__('auth.email-placeholder')"
                        type="email" name="email" :value="old('email')" required autofocus />
                </div>
                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" class="text-base font-medium" :value="__('auth.password')" />
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <x-input id="password" class="block w-full py-1.5 text-[0.9rem]" :placeholder="__('auth.password')"
                            type="password" name="password" required autocomplete="current-password" />
                        <button type="button" class="absolute inset-y-0 right-0 pl-2.5 pr-2.5 flex items-center">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                <!-- Remember Me -->
                <div class="flex justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-blue-corp shadow-sm focus:outline-none focus:ring-0 focus:border-gray-300"
                            name="remember">
                        <span class="ml-2 text-sm font-medium text-gray-900">{{ __('auth.remember') }}</span>
                    </label>
                </div>
                <div class="flex items-center mt-4">
                    <button
                        class='w-full bg-yellow-400 px-4 py-1.5 rounded-xl text-slate-50 font-semibold'>
                        {{ __('auth.login') }}
                    </button>
                </div>
            </form>
        </x-auth-card>
    </div>
</x-guest-layout>
