@extends('layout.app')
@section('extra-css')
    @vite('resources/css/patch.css')
@endsection
@section('content')
    {{-- Patches Timeline --}}
    <div id="patchContent">
        <x-shared.page-title title="Patch List" />

        @if (count($patches) > 0)
            <div class="flex justify-center">
                <x-shared.format-slider firstImg="images/filter/table-format.webp"
                    secondImg="images/filter/timeline-format.webp" />
            </div>

            <div class="flex flex-col items-center mt-3">
                <div class="w-1/2 relative mt-5">
                    <input id="searchBar" type="text" placeholder="Search..."
                        class="w-full block p-3 border rounded-md pr-12" />

                    <button id="filterToggle"
                        class="absolute inset-y-0 right-2 flex items-center p-2 rounded hover:bg-gray-100">
                        <svg class="w-5 h-5 filter-icon text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <div class="search-tree-structure w-1/2 mt-2">
                    <div class="search-tree-item mb-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="searchFilter" value="patch" class="cursor-pointer" checked>
                            <span>Patches</span>
                        </label>
                    </div>
                    <div class="search-tree-item mb-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="searchFilter" value="characters" class="cursor-pointer" checked>
                            <span>Characters</span>
                        </label>
                    </div>
                    <div class="search-tree-item mb-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="searchFilter" value="lightcones" class="cursor-pointer" checked>
                            <span>Lightcones</span>
                        </label>
                    </div>
                </div>
            </div>

            <x-patch.card-format :patches="$patches" />
            <x-patch.timeline-format :patches="$patches" />
        @else
            <div class="text-center">
                There are no patches to show.
            </div>
        @endif
    </div>

    {{-- Modal for Pictures --}}
    <x-modal.picture />

    {{-- Modal for Timeline --}}
    <x-modal.timeline-card />
@endsection
