@extends('layout.app')
@section('content')
    <div class="min-h-screen">
        <x-shared.page-title title="Login" />

        {{-- Login Form --}}
        <div
            class="flex flex-col justify-center items-center mx-auto w-1/2 bg-loginForm mt-8 rounded-lg shadow-md text-white">
            <form class="px-8 py-6 w-full" method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2" for="email">Email</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="Enter your email" name="email" required
                        autocomplete="email">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2" for="password">Password</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" type="password" placeholder="Enter your password" name="password" required
                        minlength="8" autocomplete="current-password">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-ruby hover:bg-coral font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                        type="submit">
                        Login
                    </button>
                </div>
            </form>

            <form class="px-8 py-6 w-full hidden text-white" method="POST" action="{{ route('password.change') }}"
                id="changePasswordForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2" for="email">Email</label>
                    <input
                        class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        id="checkEmail" type="email" placeholder="Enter your email" name="email" required
                        autocomplete="email" value="{{ old('email', auth()->user()?->email) }}">
                </div>
                <div class="mb-4">
                    <button type="button" id="sendCodeBtn"
                        class="bg-crimson hover:bg-ruby text-white font-semibold py-2.5 px-4 rounded-lg w-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-mauve focus:ring-offset-2">
                        Send Verification Code
                    </button>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2" for="verification_code">Verification
                        Code</label>
                    <input
                        class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        id="verification_code" type="text" inputmode="numeric" pattern="\d{6}"
                        placeholder="Enter the code" name="verification_code" autocomplete="one-time-code" minlength="6"
                        maxlength="6" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2" for="newPassword">New password</label>
                    <input
                        class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        id="newPassword" type="password" placeholder="Enter your password" name="new_password" required
                        minlength="8" autocomplete="new-password">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2" for="confirmPassword">Confirm New Password</label>
                    <input
                        class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        id="confirmPassword" type="password" placeholder="Re-enter your password"
                        name="new_password_confirmation" required minlength="8" autocomplete="new-password">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-ruby hover:bg-coral text-white font-semibold py-2.5 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 w-full transition-colors duration-200"
                        type="submit">
                        Change your password
                    </button>
                </div>
            </form>
            <div class="text-center flex flex-col pb-6">
                <p class="text-sm">No account yet? <a href="{{ route('register') }}"
                        class="text-yellow-400 hover:underline">Register</a></p>
                <p class="text-sm change-form">Forgot your password? <a class="text-yellow-400 hover:underline"
                        id="toggleLink">Reset password</a></p>
            </div>
        </div>
    </div>
@endsection
