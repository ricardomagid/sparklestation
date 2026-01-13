{{-- Shared between Character and Lightcone pages --}}
<div class="flex flex-col panel-base active-panel {{ $containerClasses }}" data-panel="overview">
    <div class="bg-darkerItemPanel p-5 rounded-lg">
        <h2 class="text-lg font-semibold text-white border-b border-white/20">Combat Stats</h2>
    </div>

    <div class="bg-itemPanel p-5 rounded-lg backdrop-blur-sm shadow-lg border border-white/10 char-stats">
        <div class="space-y-4">
            <div class="stat-row">
                <div class="flex justify-between mb-1">
                    <span class="text-white">ATK</span>
                    <span class="text-white font-medium stat-value">{{ floor($stats->atk) }}</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2">
                    <div class="bg-statBar h-2 rounded-full stat-width"
                        style="width: {{ ($stats->atk / $maxStatValues['atk']) * 100 }}%"></div>
                </div>
            </div>

            <div class="stat-row">
                <div class="flex justify-between mb-1">
                    <span class="text-white">HP</span>
                    <span class="text-white font-medium stat-value">{{ floor($stats->hp) }}</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2">
                    <div class="bg-statBar h-2 rounded-full stat-width"
                        style="width: {{ ($stats->hp / $maxStatValues['hp']) * 100 }}%"></div>
                </div>
            </div>

            <div class="stat-row">
                <div class="flex justify-between mb-1">
                    <span class="text-white">DEF</span>
                    <span class="text-white font-medium stat-value">{{ floor($stats->def) }}</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2">
                    <div class="bg-statBar h-2 rounded-full stat-width"
                        style="width: {{ ($stats->def / $maxStatValues['def']) * 100 }}%">
                    </div>
                </div>
            </div>

            @if (!is_null($stats->speed))
                <div class="stat-row">
                    <div class="flex justify-between mb-1">
                        <span class="text-white">SPD</span>
                        <span class="text-white font-medium">{{ $stats->speed }}</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-2">
                        <div class="bg-statBar h-2 rounded-full"
                            style="width: {{ ($stats->speed / $maxStatValues['speed']) * 100 }}%">
                        </div>
                    </div>
                </div>
            @endif

            <div class="stat-slider flex flex-col items-center w-full mb-4 pt-2">
                <div class="relative w-full">
                    <!-- Main slider track -->
                    <div class="w-full h-2 bg-[#FFCECE] rounded-md"></div>

                    <!-- Active part of the slider -->
                    <div class="absolute top-0 left-0 h-2 bg-[#FF4A4A] rounded-md active-track" style="width: 1%;">
                    </div>
                    <!-- Ascension markers -->
                    <div class="absolute top-0 left-0 w-full h-2 flex pointer-events-none">
                        <!-- Marker for level 20 -->
                        <div class="h-4 w-1 bg-white rounded-full absolute top-[-4px]" style="left: 25%">
                        </div>

                        <!-- Marker for level 30 -->
                        <div class="h-4 w-1 bg-white rounded-full absolute top-[-4px]" style="left: 37.5%">
                        </div>

                        <!-- Marker for level 40 -->
                        <div class="h-4 w-1 bg-white rounded-full absolute top-[-4px]" style="left: 50%">
                        </div>

                        <!-- Marker for level 50 -->
                        <div class="h-4 w-1 bg-white rounded-full absolute top-[-4px]" style="left: 62.5%">
                        </div>

                        <!-- Marker for level 60 -->
                        <div class="h-4 w-1 bg-white rounded-full absolute top-[-4px]" style="left: 75%">
                        </div>

                        <!-- Marker for level 70 -->
                        <div class="h-4 w-1 bg-white rounded-full absolute top-[-4px]" style="left: 87.5%">
                        </div>
                    </div>

                    <!-- Slider input -->
                    <input type="range" min="1" max="80" value="1"
                        class="appearance-none w-full h-2 bg-transparent absolute top-0 left-0 cursor-pointer stat-slider-input">
                </div>

                <!-- Level indicator -->
                <div class="flex justify-between w-full mt-2">
                    <span class="text-red-300 text-sm">Lv.1</span>
                    <span class="text-white text-sm font-medium level-display">Level 1</span>
                    <span class="text-red-300 text-sm">Lv.80</span>
                </div>

                <!-- Fold-out Materials Panel (hidden by default) -->
                <div class="w-full overflow-hidden smooth-transition max-h-0 materials-panel">
                    <div
                        class="bg-[#FF4A4A]/80 backdrop-blur-sm rounded-b-lg p-4 mt-2 transform origin-top shadow-lg border border-[#FF7A7A]">
                        <h3 class="text-white font-medium text-center mb-3">Ascension Materials</h3>
                        <div class="flex justify-center gap-4 flex-wrap materials-container">
                            <!-- Materials Needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
