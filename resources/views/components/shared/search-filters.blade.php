{{-- Search Bar --}}
<input id="search" type="text" placeholder="Search..." class="w-full block p-1 mt-5"/>
{{-- Search Filters --}}
<div class="flex gap-5 flex-wrap gap-y-1 justify-center">
    <div class="flex gap-2">
        @foreach($paths as $path)
            <div class="path-filter filter-button" data-type="path" data-value="{{ $path->name }}">
                <img src="{{ $path->img }}">
            </div>
        @endforeach
    </div>
    @if(isset($elements) && $elements)
        <div class="flex gap-2">
            @foreach($elements as $element)
                <div class="element-filter filter-button" data-type="element" data-value="{{ $element->name }}">
                    <img src="{{ $element->img }}" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
    @endif
    <div class="flex gap-2">
        @if($isCharacter==false)
            <div class="rarity-filter filter-button flex items-center justify-center" data-type="rarity" data-value="3">
                <p class="text-white">3 ✦</p>
            </div>        
        @endif
        <div class="rarity-filter filter-button flex items-center justify-center" data-type="rarity" data-value="4">
            <p class="text-white">4 ✦</p>
        </div>
        <div class="rarity-filter filter-button flex items-center justify-center" data-type="rarity" data-value="5">
            <p class="text-white">5 ✦</p>
        </div>
    </div>
    <!-- Table/Icon Table Slider -->
    <x-shared.format-slider firstImg="images/filter/icon-format.webp" secondImg="images/filter/table-format.webp"/>
    <div class="flex gap-2">
        <!-- Remove Filter Icon -->
        <div id="remove-filter" class="filter-button">
            <img src="{{ asset('images/filter/remove-filter.webp') }}" class="w-full h-full object-cover p-1">
        </div>
        <!-- Filter Modal Icon -->
        <div class="filter-button table-filter-button hidden">
            <img src="{{ asset('images/filter/filter-modal.webp') }}" class="w-full h-full object-cover rounded p-1" onclick="openFilterModal('{{ $isCharacter }}')"/>
        </div>
    </div>
</div>