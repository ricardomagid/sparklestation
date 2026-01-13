{{-- Modal for Filters --}}
<div class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 justify-center items-center modal-enter-active modal-leave-active opacity-0 transform scale-95" id="filterModal">
    <div class="flex flex-col p-6 bg-ruby border border-coral rounded-lg shadow-xl max-w-md w-full">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-white font-bold text-lg">Table Filter</h3>
            <button class="text-white hover:text-mauve" onclick="closeFilterModal()">✖</button>
        </div>
        
        <div class="mb-4">
            <h4 class="text-white font-semibold mb-2">Columns:</h4>
            <div class="grid grid-cols-3 gap-3" id="column-filter">
                @php
                    $columnOptions = [
                        ['id' => 'rarity', 'label' => 'Rarity', 'character_only' => false],
                        ['id' => 'element', 'label' => 'Element', 'character_only' => true],
                        ['id' => 'path', 'label' => 'Path', 'character_only' => false],
                        ['id' => 'faction', 'label' => 'Faction', 'character_only' => true],
                        ['id' => 'atk', 'label' => 'ATK', 'character_only' => false],
                        ['id' => 'hp', 'label' => 'HP', 'character_only' => false],
                        ['id' => 'def', 'label' => 'DEF', 'character_only' => false],
                        ['id' => 'speed', 'label' => 'Speed', 'character_only' => true],
                    ];
                @endphp

                @foreach($columnOptions as $option)
                    @if(!$option['character_only'] || $isCharacter)
                        <div class="flex items-center">
                            <input type="checkbox" 
                                id="show-{{ $option['id'] }}" 
                                name="column" 
                                value="{{ $option['id'] }}" 
                                class="mr-2">
                            <label for="show-{{ $option['id'] }}" class="text-white">{{ $option['label'] }}</label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="mb-4">
            <label for="column-order" class="block text-white mb-2">Sort:</label>
            <select id="column-order" name="column-order" class="w-full p-2 bg-white rounded">
                <option value="id" selected>ID</option>
                <option value="item">Name</option>
                @foreach($columnOptions as $option)
                    @if(!$option['character_only'] || $isCharacter)
                        <option value="{{ $option['id'] }}">{{ $option['label'] }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="column-direction" class="block text-white mb-2">Order:</label>
            <select id="column-direction" name="column-direction" class="w-full p-2 bg-white rounded">
                <option value="desc" selected>Descending</option>
                <option value="asc">Ascending</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label for="items-per-page" class="block text-white mb-2">Items per page:</label>
            <select id="items-per-page" name="items-per-page" class="w-full p-2 bg-white rounded">
                <option value="10">10</option>
                <option value="20" selected>20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        
        <div class="flex justify-end mt-4">
            <button id="apply-filters-btn" class="bg-coral hover:bg-crimson text-white py-2 px-4 rounded">
                Apply Filters
            </button>
        </div>
    </div>
</div>