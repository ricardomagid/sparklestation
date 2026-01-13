@props(['userId', 'variant' => 'top'])

@php
    switch ($variant) {
        case 'right':
            // Vertical Column
            $containerClasses = 'flex flex-col items-center gap-3 w-full px-6';
            $loginClasses = 'w-full text-center px-4 py-2';
            $registerClasses = 'w-full text-center px-4 py-2';
            $imageClasses = 'w-32 h-32';
            $imageOrder = '';
            break;

        default:
            // Horizontal Row
            $containerClasses = 'flex items-center gap-3';
            $loginClasses = 'px-2 py-1 text-xs';
            $registerClasses = 'px-2 py-1 text-xs';
            $imageClasses = 'w-10 h-10';
            $imageOrder = 'order-first';
            break;
    }
@endphp

@auth
    <div data-profile-container class="{{ $containerClasses }}">
        
        <p class="text-white user-username">{{ auth()->user()->username }}</p>

        <div class="relative {{ $imageClasses }} {{ $imageOrder }} rounded-full overflow-hidden group border-2 border-red-800"
            onclick="this.closest('[data-profile-container]').querySelector('.profile-pic-input').click()">
            <img src="{{ auth()->user()->img }}" data-filename="{{ auth()->user()->profile_pic ?? 'default.webp' }}"
                alt="Profile Picture" class="object-cover w-full h-full user-picture">
            <div
                class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0 00.707-.293l9.414-9.414a1 1 0 000-1.414l-4.586-4.586a1 1 0 00-1.414 0L4 14.586V20z" />
                </svg>
            </div>
        </div>

        <input type="file" class="hidden profile-pic-input" accept="image/*" onchange="previewAndUpload(this)">

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="auth-button flex items-center gap-2 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>
    </div>
@endauth

@guest
    <div class="{{ $containerClasses }}">
        <a href="{{ route('login') }}" class="auth-button {{ $loginClasses }}">Login</a>
        <a href="{{ route('register') }}" class="auth-button {{ $registerClasses }}">Create Account</a>
    </div>
@endguest