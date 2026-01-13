<div class="active-panel right-panel" data-panel="overview">
    <!-- Header -->
    <div class="bg-darkerItemPanel text-[#FFD1D1] text-center py-2">
        <h2 class="text-lg font-semibold tracking-wide">Details</h2>
    </div>

    <!-- Lightcone Details -->
    <div class="flex relative items-stretch h-auto min-h-0">
        <div class="w-[80%] relative z-0 mobile-details-section self-stretch flex flex-col min-h-0">
            <table class="mobile-details-table flex-1 min-h-0 w-full">
                <tr>
                    <th>Rarity:</th>
                    <td>{{ str_repeat('⭐', $lightcone->rarity) }}</td>
                </tr>
                <tr>
                    <th>Path:</th>
                    <td>{{ $lightcone->path->name ?? 'Unknown' }}</td>
                </tr>
                <tr>
                    <th>Story:</th>
                    <td>
                        <div class="story-wrapper flex-1 min-h-0">
                            <div class="text-gray-100 text-sm leading-relaxed rounded p-3 bg-black/10 story-text h-full overflow-y-auto"
                                id="storyText" aria-live="polite">
                                {!! $lightcone->story ?? '<em class="text-gray-300">No story available.</em>' !!}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="w-[20%] flex relative z-10 self-stretch min-h-0 bg-itemPanel items-center">
            <img src="{{ $lightcone->img }}" class="w-full h-full max-h-[290px] object-cover object-top hover:scale-105"
                onclick="openImageModal('{{ $lightcone->artwork_img }}')" />
        </div>
    </div>
</div>
