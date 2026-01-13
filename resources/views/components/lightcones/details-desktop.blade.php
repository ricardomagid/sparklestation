<div class="flex bg-itemPanel gap-4 p-4 rounded-lg flex-1">
    <div class="flex-shrink-0 mx-auto lg:mx-0">
        <div class="relative group" onclick="openImageModal('{{ $lightcone->artwork_img }}')">
            <img class="cursor-pointer w-64 h-80 rounded-lg shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-2xl"
                id="lc-image" src="{{ $lightcone->img }}" alt="{{ $lightcone->name }}" />
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
            </div>
        </div>
    </div>
    <div id="lc-details" class="smooth-transition transform flex-1 min-w-0">
        <h2 class="text-lg font-semibold text-white mb-3 border-b border-white/20 pb-2">
            {{ $lightcone->name }}
        </h2>
        <div class="space-y-3 text-white/90">
            <div class="flex justify-between items-center">
                <span class="font-bold">Rarity:</span>
                <span class="font-medium">{{ str_repeat('⭐', $lightcone->rarity) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Path:</span>
                <span class="font-medium">{{ $lightcone->path->name ?? 'Unknown' }}</span>
            </div>
            <div class="space-y-2">
                <span class="font-bold block">Story:</span>
                <div class="text-sm text-white/80 leading-relaxed p-3 story-text">
                    {!! $lightcone->story ?? 'No story available.' !!}
                </div>
            </div>
        </div>
    </div>
</div>
