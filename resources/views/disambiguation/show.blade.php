@extends('layout.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8 flex flex-col items-center">
            <h2 class="text-3xl font-bold text-black mb-2">
                Multiple {{ Str::plural($entity_type) }} Found
            </h2>
            <p class="text-black">
                Which {{ strtolower($entity_type) }} were you looking for?
            </p>
        </div>

        <div class="flex flex-wrap justify-center gap-6">
            @foreach ($items as $item)
                @php
                    if ($entity_route_prefix === 'relics') {
                        $type = $model_class === \App\Models\Relic::class ? 'relic' : 'planar';
                        $url = route('relics.show', ['type' => $type, 'item' => $item->slug]);
                    } else {
                        $url = route($entity_route_prefix . '.show', $item->slug);
                    }
                @endphp
                <a href="{{ $url }}"
                    class="group bg-itemPanel rounded-lg overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-red-900/20 border-2 border-transparent hover:border-red-500/50 -full sm:w-1/4 lg:w-1/5 xl:w-1/6 flex flex-col">

                    <div class="relative aspect-square bg-gradient-to-br from-red-900/20 to-red-950/40 overflow-hidden">
                        @if ($item->model_img ?? ($item->img ?? false))
                            <img src="{{ $item->model_img ?? $item->img }}" alt="{{ $item->name }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif

                        @if ($item->element ?? false)
                            <div
                                class="absolute top-3 right-3 bg-black/60 backdrop-blur-sm rounded-full p-2 transition-transform duration-300 group-hover:scale-105">
                                <img src="{{ $item->element_img }}" alt="{{ $item->element->name }}" class="w-8 h-8">
                            </div>
                        @endif
                        @if ($item->path ?? false)
                            <div
                                class="absolute top-3 left-3 bg-black/60 backdrop-blur-sm rounded-full p-2 transition-transform duration-300 group-hover:scale-105">
                                <img src="{{ $item->path_img }}" alt="{{ $item->path->name }}" class="w-8 h-8">
                            </div>
                        @endif
                    </div>

                    <div class="p-4 bg-gradient-to-b from-itemPanel to-black/40 flex-grow flex items-center justify-center">
                        <h3
                            class="text-lg font-semibold text-white text-center group-hover:text-red-400 transition-colors duration-300">
                            {{ $item->name }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
