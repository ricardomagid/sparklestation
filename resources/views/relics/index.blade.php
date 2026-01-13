@extends('layout.app')
@section('extra-css')
    @vite('resources/css/relic.css')
@endsection
@section('content')
    <div id="relicContent">
        <div class="flex flex-col items-center justify-start mx-5">
            <div class="max-w-screen-lg w-full">
                <x-shared.page-title title="{{ $selectedItem ? 'Relic Details' : 'Relic List' }}" />

                <button id="backBtn"
                    class="bg-darkerItemPanel text-white px-4 py-2 rounded-lg hover:bg-black/30 transition-all duration-300 border border-white/20 {{ $selectedItem ? '' : 'hidden' }}">
                    ← Back to List
                </button>

                @if (count($items) > 0)
                    <div id="listView" class="{{ $selectedItem ? 'hidden' : '' }}">
                        <div
                            class="flex flex-col sm:flex-row w-full items-stretch sm:items-center gap-3 mb-6 bg-redPanel p-4 rounded-lg">
                            <div class="flex gap-2">
                                <button class="relic-filter-btn px-4 py-2 font-medium active" id="relicFilter">
                                    Relics
                                </button>
                                <button class="relic-filter-btn px-4 py-2 font-medium active" id="planarFilter">
                                    Planar Ornaments
                                </button>
                            </div>
                            <input type="text"
                                class="flex-1 h-10 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-700 focus:border-transparent transition-shadow"
                                name="relicSearch" id="relicSearch" placeholder="Search relics...">
                        </div>

                        <div class="flex flex-wrap justify-evenly gap-3 md:gap-4">
                            @foreach ($items as $item)
                                <div class="group flex item-card w-16 sm:w-20 md:w-24 lg:w-28" data-id="{{ $item->id }}"
                                    data-type="{{ $item->item_type }}" data-name="{{ $item->name }}"
                                    @foreach ($item->getEffects() as $key => $effect)
                                @if ($effect) data-{{ $key }}="{{ $effect }}" @endif @endforeach>
                                    <img src="{{ $item->img }}" alt="{{ $item->name }}"
                                        class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300 drop-shadow-md">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        There are no relics to show.
                    </div>
                @endif

                <div id="detailsView" class="{{ $selectedItem ? '' : 'hidden' }}">
                    @if ($selectedItem)
                        @include('relics.partials.relic-details', [
                            $selectedItem->type === 'relic' ? 'relic' : 'planar' => $selectedItem,
                        ])
                    @endif

                </div>

                <x-shared.pop-up-table :enableWallpaper="false" :rows="[
                    'Name' => 'Name',
                    'FirstSet' => '2pc Set Effect:',
                    'SecondSet' => '4pc Set Effect:',
                ]" />
            </div>
        </div>
        {{-- Loading State --}}
        <x-modal.loading-state loading="Loading relic details..." />
    </div>
@endsection
