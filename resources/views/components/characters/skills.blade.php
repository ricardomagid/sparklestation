@if ($format == 'desktop')
    <div class="mx-auto panel-base w-[65%] h-[80%] absolute right-5 top-5 bottom-5 p-5 panel-enter right-panel panel-hidden flex flex-col panel-base"
        data-panel="skills">
    @elseif($format == 'mobile')
        <div class="mx-auto panel-base panel-enter right-panel panel-hidden flex flex-col panel-base" data-panel="skills">
@endif

<!-- Tab Navigation -->
<div class="flex border-b border-red-800/70 order-2 xl:order-1 skill-navigation">
    @foreach ($character->grouped_abilities as $category => $abilities)
        <button
            class="px-5 py-3 mr-1 text-white smooth-transition hover:bg-red-600/90 flex items-center
                {{ $loop->first ? 'skill-tab-active' : 'skill-tab-unactive' }}"
            data-category="{{ Str::slug($category) }}">
            {{ $category }}
        </button>
    @endforeach
</div>

<!-- Tab Content Panels -->
<div
    class="bg-itemPanel xl:rounded-lg backdrop-blur-sm shadow-lg border border-white/10 overflow-auto h-full ability-panel order-1 xl:order-2">
    @foreach ($character->grouped_abilities as $category => $abilities)
        @php
            $max = $category === 'Basic ATK' ? 10 : 15;
            $default = $category === 'Basic ATK' ? 7 : 10;
        @endphp

        <div class="p-6 h-full {{ $loop->first ? '' : 'hidden' }}" id="panel-{{ Str::slug($category) }}"
            data-skill-panel={{ Str::slug($category) }}>
            @if ($category != 'Technique')
                <div class="flex items-center mb-6 bg-black/15 p-3 rounded-lg">
                    <span class="text-white text-sm mr-3 w-20">Level: <span class="ability-slider-number"></span></span>
                    <input type="range" min="1" max="{{ $max }}" value="{{ $default }}"
                        class="ability-slider skill-slider h-2 flex-grow appearance-none rounded-lg bg-red-800/50 accent-red-600"
                        data-ability="{{ Str::slug($category) }}">
                </div>
            @endif

            <div class="space-y-8">
                @foreach ($abilities as $i => $ability)
                    <div class="{{ !$loop->first ? 'pt-6 border-t border-white/15' : '' }}">
                        <!-- Ability Header -->
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-br from-red-700 to-red-900 rounded-full p-2 mr-3 shadow-lg">
                                <img src="{{ $ability->img($i) }}" alt="{{ $ability->name }}" class="w-10 h-10">
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">{{ $ability->name }}</h2>
                                @if ($ability->type)
                                    <span class="text-white/80 text-sm">{{ $ability->type->name }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Ability Stats -->
                        @if ($ability->toughness_reduction > 0 || $ability->energy > 0)
                            <div class="grid grid-cols-2 gap-6 mb-4 bg-black/15 rounded-lg p-4">
                                @if ($ability->toughness_reduction > 0)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-red-400" ...></svg>
                                        <span class="text-white/90 text-sm">Toughness Reduction:</span>
                                        <span class="text-white font-bold">{{ $ability->toughness_reduction }}</span>
                                    </div>
                                @endif
                                @if ($ability->energy > 0)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-red-400" ...></svg>
                                        <span class="text-white/90 text-sm">Energy Regeneration:</span>
                                        <span class="text-white font-bold">{{ $ability->energy }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Ability Description -->
                        <div class="bg-white/5 rounded-lg p-4">
                            <h3 class="text-red-300 mb-1 text-sm font-medium uppercase tracking-wide">Description
                            </h3>
                            <p class="text-white text-[15px] leading-relaxed ability-description"
                                data-base-numbers='@json($ability->base_numbers)' data-ability-id="{{ $ability->id }}">
                                {!! $ability->description ?? 'No description available.' !!}
                            </p>
                        </div>
                    </div>

                    @if ($category === 'Talent' && $character->universal_buff)
                        <button class="unique-buffs-button relative flex items-center hover:scale-110"
                            onclick="openUniqueBuffsModal()">
                            <div class="relative z-10 -mr-6 h-12 w-12 transition-transform">
                                <img src="{{ $character->unique_buffs_img }}" alt="Unique Buffs"
                                    class="h-full w-full object-contain filter drop-shadow-md">
                            </div>

                            <div
                                class="flex items-center rounded-full border border-pink-300/50 bg-black/40 py-1 pl-8 pr-4 backdrop-blur-sm">
                                <p class="text-sm font-medium text-pink-100 antialiased">
                                    {{ $character->universal_buff->name }}
                                </p>
                            </div>
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</div>
</div>
