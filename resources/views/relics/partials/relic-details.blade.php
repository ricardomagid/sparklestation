<div class="flex flex-col gap-6 p-2 mt-5">
    <div class="bg-itemPanel rounded-lg p-6 space-y-3 shadow-xl">
        <h2 class="text-3xl font-bold text-white border-b border-white/20 pb-3">
            {{ $selectedItem->name }}
        </h2>
        <div class="space-y-2">
            <div
                class="flex items-start gap-3 p-3 bg-black/20 rounded-md border-l-4 border-yellow-500 hover:bg-black/30 transition-colors">
                <span class="text-yellow-400 font-semibold text-sm mt-0.5 min-w-[80px]">2PC Effect</span>
                <p class="text-white/90 flex-1">{!! $selectedItem->getHighlightedFirstEffect() !!}</p>
            </div>
            @if ($selectedItem->second_effect)
                <div
                    class="flex items-start gap-3 p-3 bg-black/20 rounded-md border-l-4 border-yellow-500 hover:bg-black/30 transition-colors">
                    <span class="text-yellow-400 font-semibold text-sm mt-0.5 min-w-[80px]">4PC Effect</span>
                    <p class="text-white/90 flex-1">{!! $selectedItem->getHighlightedSecondEffect() !!}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="bg-itemPanel rounded-lg p-8 shadow-xl">
            <div class="gap-4 w-full max-w-96 mx-auto h-96 relic-wrapper" id="{{ $selectedItem->item_type }}Wrapper">
                @foreach ($selectedItem->relicPieces ?? $selectedItem->planarOrnamentPieces as $piece)
                    <div data-name="{{ $piece->name }}" data-story="{{ $piece->story }}"
                        class="relic-piece group relative bg-black/20 rounded-xl p-4 cursor-pointer transition-all duration-300 hover:scale-110 hover:z-10 border-2 border-white/20 hover:border-yellow-400 hover:shadow-lg hover:shadow-yellow-500/30">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-yellow-600/0 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl">
                        </div>
                        <img src="{{ $piece->img }}" alt="{{ $piece->name }}"
                            class="relative w-full h-full object-contain drop-shadow-lg group-hover:drop-shadow-2xl transition-all duration-300">
                        <div
                            class="absolute inset-0 bg-yellow-400/0 group-hover:bg-yellow-400/10 rounded-xl transition-colors duration-300">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-itemPanel rounded-lg flex-1 shadow-xl h-[28rem] p-6">
            <div class="flex flex-col gap-4 h-full">
                <div class="flex items-center gap-3 pb-3 border-b border-white/20 overflow-auto">
                    <div
                        class="w-2 h-8 bg-gradient-to-b from-yellow-500 to-yellow-600 rounded-full shadow-lg shadow-yellow-500/50">
                    </div>
                    <h3 id="relicTitle" class="text-2xl font-bold text-white min-h-[2rem]">
                        Select a relic piece to view details
                    </h3>
                </div>
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    <p id="relicStory" class="text-white/90 leading-relaxed text-base tracking-wide">
                        Click on any relic piece to reveal its story...
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
