<div class="active-panel right-panel" data-panel="overview">
    <!-- Header -->
    <div class="bg-darkerItemPanel text-[#FFD1D1] text-center py-2">
        <h2 class="text-lg font-semibold tracking-wide">Character Details</h2>
    </div>
    <div class="h-full flex relative">
        <!-- Character Details -->
        <div class="w-[80%] relative z-0">
            <table class="mobile-details-table">
                <tr>
                    <th>Rarity:</th>
                    <td>{{ str_repeat('⭐', $character->rarity) }}</td>
                </tr>
                <tr>
                    <th>Element:</th>
                    <td>{{ $character->element->name ?? 'Unknown' }}</td>
                </tr>
                <tr>
                    <th>Path:</th>
                    <td>{{ $character->path->name ?? 'Unknown' }}</td>
                </tr>
                <tr>
                    <th>Faction:</th>
                    <td>{{ $character->faction->name ?? 'Unknown' }}</td>
                </tr>
                <tr>
                    <th>Story:</th>
                    <td>{{ $character->story->char_intro ?? 'Unknown' }}</td>
                </tr>
            </table>
        </div>
        <!-- Model -->
        <div class="w-[20%] flex items-stretch relative z-10">
            <img src="{{ $character->model_img }}" class="object-cover object-top w-auto max-h-full bg-itemPanel"
                alt="{{ $character->name }}" id="tableMobileModel">
        </div>
    </div>

    <!-- Character Stats -->
    <div class="bg-itemPanel w-full flex justify-center p-2">
        <div class="sparkle-button cursor-pointer" id="charStatsButton">
            Character Stats
        </div>
    </div>
    <div class="max-h-0 opacity-0 overflow-hidden panel-base bg-darkerItemPanel" id="statsPanel">
        <x-shared.stats :stats="$stats" :maxStatValues="$maxStatValues" containerClasses="" />
    </div>
</div>
