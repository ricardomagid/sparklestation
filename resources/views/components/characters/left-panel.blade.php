<div class="w-1/4 smooth-transition opacity-100 scale-100 flex flex-col gap-4">
    <div class="bg-red-700 p-5 rounded-lg backdrop-blur-sm shadow-lg border border-white/10">
        <div class="flex items-center mb-3">
            <img src="{{ $character->element_img }}" alt="{{ $character->element->name }}"
                class="w-8 h-8 transition-transform hover:scale-110">
            <img src="{{ $character->path_img }}" alt="{{ $character->path->name }}"
                class="w-8 h-8 ml-3 transition-transform hover:scale-110">
        </div>

        <h1 class="text-2xl font-bold text-white tracking-wide">{{ $character->name }}</h1>
        <div class="h-1 w-16 mt-2 rounded-full" style="background-color: {{ $character->element->color }}">
        </div>
    </div>

    <div class="bg-itemPanel p-5 rounded-lg backdrop-blur-sm shadow-lg border border-white/10 flex-1">
        <div id="char-details" class="smooth-transition transform">
            <h2 class="text-lg font-semibold text-white mb-3 border-b border-white/20 pb-2">Character Details</h2>
            <div class="space-y-2 text-white/90">
                <p class="flex justify-between">
                    <span class="font-bold">Rarity:</span>
                    <span class="font-medium">{{ str_repeat('⭐', $character->rarity) }}</span>
                </p>
                <p class="flex justify-between">
                    <span class="font-bold">Element:</span>
                    <span class="font-medium">{{ $character->element->name ?? 'Unknown' }}</span>
                </p>
                <p class="flex justify-between">
                    <span class="font-bold">Path:</span>
                    <span class="font-medium">{{ $character->path->name ?? 'Unknown' }}</span>
                </p>
                <p class="flex justify-between">
                    <span class="font-bold">Faction:</span>
                    <span class="font-medium">{{ $character->faction->name ?? 'Unknown' }}</span>
                </p>
                <p class="flex justify-between">
                    <span class="font-bold">Story:</span>
                </p>
                <p class="flex justify-between">
                    <span class="text-sm text-white/80 leading-relaxed">
                        {{ $character->story->char_intro ?? 'Unknown' }}</span>
                </p>
            </div>
        </div>
        <div id="char-model"
            class="flex justify-center items-start h-full panel-hidden absolute inset-0 smooth-transition transform panel-exit overflow-hidden">
            <img src="{{ $character->model_img }}" class="h-full w-auto object-cover"
                style="object-position: 30% 0%;" />
        </div>
    </div>
</div>
