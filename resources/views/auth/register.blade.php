@extends('layout.app')
@section('content')
    <div class="min-h-screen">
        <x-shared.page-title title="Create Your Account" />

        {{-- Register Form --}}
        <div class="flex justify-center items-center mx-auto w-1/2 bg-loginForm mt-8 rounded-lg shadow-md">
            <form class="px-8 py-6 w-full text-white" id="registerform" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="username">Username</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="username" type="text" placeholder="Enter your username" name="username"
                        value="{{ old('username') }}" minlength="3" maxlength="20" required autocomplete="username">
                    <p class="error font-bold text-xs mt-1 hidden" id="usernameError">No special characters allowed</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="email">Email</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="Enter your email" name="email"
                        value="{{ old('email') }}" required autocomplete="email">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="password">Password</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" type="password" placeholder="Enter your password" name="password" minlength="8"
                        required autocomplete="new-password">
                    <div class="flex justify-between content-center">
                        <p class="text-gray-300 text-xs mt-1">Minimum 8 characters</p>
                        <div class="flex content-center mt-2">
                            <input type="checkbox" id="showPassword" tabindex="-1">
                            <p class="text-xs ml-1">Show</p>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2" for="passwordConfirmation">Confirm Password</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="passwordConfirmation" type="password" placeholder="Confirm your password"
                        name="password_confirmation" required autocomplete="new-password">
                    <p class="error font-bold text-xs mt-1 hidden" id="passwordError">Passwords do not match</p>
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-ruby hover:bg-coral text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                        type="submit">
                        Sign Up
                    </button>
                </div>
                <div class="text-center mt-4">
                    <p class="text-white text-sm">Already have an account? <a href="{{ route('login') }}"
                            class="text-yellow-400 hover:underline">Log in</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection
