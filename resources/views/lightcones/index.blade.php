@extends('layout.app')
@section('content')
    {{-- Lightcone List --}}
    <div class="flex flex-col items-center justify-center mx-5" id="lightconePage">
        <x-shared.page-title title="Lightcone List" />

        <div class="max-w-screen-md w-full mt-5">
            @if (count($lightcones) > 0)
                {{-- Search Bar and Filters --}}
                <x-shared.search-filters :paths="$paths" :isCharacter="false" />
                {{-- Lightcone List in Icon Format --}}
                <x-shared.icon-format :items="$lightcones" :isCharacter="false" />
                {{-- Lightcone List in Table Format (hidden by default) --}}
                <div class="item-section-table hidden">
                    {{-- Desktop Table Format --}}
                    <x-shared.table-format-md-above :items="$lightcones" :title="'Lightcone'" />
                    {{-- Mobile Table Format --}}
                    <x-shared.table-format-md-below :items="$lightcones" :isCharacter="false" />
                    {{-- Pagination --}}
                    <div class="pagination-nav flex justify-center pt-5">
                        {{-- Automatically filled up with JS --}}
                    </div>
                </div>
            @else
                <div class="text-center">
                    There are no lightcones to show.
                </div>
            @endif
        </div>
    </div>

    {{-- Hidden Filter Modal --}}
    <x-modal.filter :isCharacter="false" />
@endsection
