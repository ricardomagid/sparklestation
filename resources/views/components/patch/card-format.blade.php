<div class="mt-3 ml-3 relative" id="cardFormat">
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-red-600 via-red-500 to-red-300 rounded-full">
    </div>

    @php
        $currentArc = null;
        $arcOpen = false;
    @endphp

    @foreach ($patches as $patch)
        @php
            $arc = optional($patch->storyArc);
            $arcName = $arc->name ?? 'Unknown Arc';
        @endphp

        {{-- If this patch belongs to a new story arc, close previous wrapper and open new --}}
        @if ($arcName !== $currentArc)
            @if ($arcOpen)
</div>
@endif

{{-- Open new arc section --}}
<div class="story-arc-section mb-8">
    <div class="arc-header flex items-center mb-4 ml-6">
        <div class="arc-header-circle w-6 h-6 bg-red-600 rounded-full border-4 border-white shadow-lg relative z-10">
        </div>
        <h2 class="text-xl font-semibold ml-4 text-red-800 px-3 py-1 rounded-lg shadow-sm">
            {{ $arcName }}
        </h2>
    </div>

    @php
        $currentArc = $arcName;
        $arcOpen = true;
    @endphp
    @endif

    <div class="patch-card relative mb-4 ml-6 show">
        <div
            class="patch-circle absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-white border-3 border-red-500 shadow-md z-10">
        </div>

        <div
            class="patch-content-wrapper bg-itemPanel backdrop-blur-sm rounded-lg shadow-lg border border-red-100 hover:shadow-xl transition-all duration-300 ml-4">
            <div class="flex items-start gap-4 p-4">
                <div class="patch-card-content flex flex-col flex-1 relative">
                    <div class="flex justify-between items-center mb-3">
                        <div class="font-semibold text-gray-800 text-lg patch-name">
                            {{ $patch->formatted_number }} {{ $patch->name }}
                        </div>
                        <div
                            class="bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-full px-3 py-1 text-sm font-medium">
                            {{ $patch->formatted_duration }}
                        </div>
                    </div>

                    <div class="flex justify-between gap-6 item-list">
                        <div class="character-section flex flex-col flex-1">
                            <p class="font-medium text-gray-700 mb-2 text-sm uppercase tracking-wide">Characters
                            </p>
                            <div class="flex flex-wrap gap-1 items-center item-container">
                                @foreach ($patch->characters as $char)
                                    <x-shared.item-icon :i="$char" :isCharacter="true" />
                                @endforeach
                            </div>
                        </div>

                        <div class="lightcone-section flex flex-col flex-1">
                            <p class="font-medium text-gray-700 mb-2 text-sm uppercase tracking-wide">Lightcones
                            </p>
                            <div class="flex flex-wrap gap-1 items-center item-container">
                                @foreach ($patch->lightcones as $lc)
                                    <x-shared.item-icon :i="$lc" :isCharacter="false" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="patch-wallpaper w-36 h-36 bg-no-repeat bg-cover bg-center rounded-xl border-2 border-red-200 flex-shrink-0 hover:scale-105 transition-all duration-300 cursor-pointer shadow-lg hover:border-red-400 hover:shadow-xl"
                    style="background-image: url('{{ asset($patch->img) }}')"
                    alt="Patch {{ $patch->formatted_number }} Image" onclick="openImageModal('{{ $patch->img }}')">
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Close the last arc wrapper --}}
    @if ($arcOpen)
</div>
@endif
</div>
