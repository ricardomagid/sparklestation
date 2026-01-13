@extends('layout.app')
@section('content')
    {{-- Character List --}}
    <div class="flex flex-col items-center justify-center mx-5" id="characterPage">
        <x-shared.page-title title="Character List" />

        <div class="max-w-screen-md w-full mt-5">
            @if(count($characters) > 0)
                {{-- Search Bar and Filters --}}
                <x-shared.search-filters :paths="$paths" :elements="$elements" :isCharacter="true" />
                {{-- Character List in Icon Format --}}
                <x-shared.icon-format :items="$characters" :isCharacter="true" />
                {{-- Character List in Table Format (hidden by default) --}}
                <div class="item-section-table hidden">
                    {{-- Desktop Table Format --}}
                    <x-shared.table-format-md-above :items="$characters" :title="'Character'" />
                    {{-- Mobile Table Format (stacked card layout) --}}
                    <x-shared.table-format-md-below :items="$characters" :isCharacter="true" />
                    {{-- Pagination --}}
                    <div class="pagination-nav flex justify-center pt-5">
                        {{-- Automatically filled up with JS --}}
                    </div>
                </div>
            @else
                <div class="text-center">
                    There are no characters to show.
                </div>
            @endif
        </div>
    </div>

    {{-- Hidden Filter Modal --}}
    <x-modal.filter :isCharacter="true" />
@endsection
