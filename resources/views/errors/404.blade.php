@php
    $url = request()->url();
    $segments = request()->segments();
    
    if (count($segments) > 0) {
        array_pop($segments);
        $route = url(implode('/', $segments));
    } else {
        $route = url('/');
    }
@endphp

@extends('layout.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-[60vh] px-4 mt-10">
        <div class="text-center">
            <h1 class="text-8xl font-bold text-red-700 mb-4">404</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                {{ $entity ?? 'Entity' }} Not Found
            </h2>
            <p class="text-gray-600 mb-8">
                The {{ strtolower($entity) ?? 'page' }} you are looking for does not exist.
            </p>

            @if(!empty($route))
                <a href="{{ $route }}"
                   class="inline-block bg-red-700 hover:bg-red-800 text-white font-medium px-6 py-3 rounded transition-colors">
                    ← Back to {{ strtolower($entity) }} list
                </a>
            @endif
        </div>
    </div>
@endsection
