{{-- Mobile Table Format (stacked card layout) --}}
<div class="w-full md:hidden">
    <div class="mobile-item-table">
        @foreach ($items as $i)
            @php
                $i->link = $isCharacter ? route('characters.show', $i->id) : route('lightcones.show', $i->id);
            @endphp
            <div class="item border-b border-ruby p-4 mb-4" data-element="{{ $i->element?->name }}"
                data-path="{{ $i->path->name }}" data-rarity="{{ $i->rarity }}" data-name="{{ $i->name }}"
                data-id="{{ $i->id }}">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <a href="{{ $i->link }}">
                            <img src="{{ $i->icon_img }}" alt="{{ $i->name . ' Icon' }}"
                                class="h-20 w-22 rounded-full border-4 border-ruby" />
                        </a>
                        <div class="hidden data-item">{{ $i->name }}</div>
                    </div>
                    <div class="flex-1 flex-wrap">
                        <div class=" data-item">
                            <a href="{{ $i->link }}">
                                <h3 class="text-lg font-semibold mb-1">{{ $i->name }}</h3>
                            </a>
                        </div>
                        <div class="columns-2 space-y-1">
                            <div class="break-inside-avoid text-sm text-gray-600 data-rarity">
                                <span class="font-bold">Rarity:</span> {{ $i->rarity }} <span>★</span>
                            </div>
                            @if ($i->faction?->name)
                                <div class="break-inside-avoid text-sm text-gray-600 data-element">
                                    <span class="font-bold">Element:</span> {{ $i->element->name }}
                                </div>
                            @endif
                            <div class="break-inside-avoid text-sm text-gray-600 data-path">
                                <span class="font-bold">Path:</span> {{ $i->path->name }}
                            </div>
                            @if ($i->faction?->name)
                                <div class="break-inside-avoid text-sm text-gray-600 data-faction">
                                    <span class="font-bold">Faction:</span> {{ $i->faction->name }}
                                </div>
                            @endif
                            <div class="break-inside-avoid text-sm text-gray-600 data-atk">
                                <span class="font-bold">ATK:</span> {{ $i->stats->atk }}
                            </div>
                            <div class="break-inside-avoid text-sm text-gray-600 data-hp">
                                <span class="font-bold">HP:</span> {{ $i->stats->hp }}
                            </div>
                            <div class="break-inside-avoid text-sm text-gray-600 data-def">
                                <span class="font-bold">DEF:</span> {{ $i->stats->def }}
                            </div>
                            @if ($i->stats->speed)
                                <div class="break-inside-avoid text-sm text-gray-600 data-speed">
                                    <span class="font-bold">Speed:</span> {{ $i->stats->speed }}
                                </div>
                            @endif
                            <div class="hidden data-id">
                                <span class="font-bold">ID:</span> {{ $i->id }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
