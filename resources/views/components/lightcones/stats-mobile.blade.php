<!-- Lightcone Stats -->
<div class="bg-itemPanel w-full flex justify-center p-2 flex-shrink-0">
    <div class="sparkle-button cursor-pointer" id="lcStatsButton">Lightcone Stats</div>
</div>

<div class="max-h-0 opacity-0 overflow-hidden panel-base bg-darkerItemPanel flex-shrink-0 transition-all duration-500 ease-in-out"
    id="statsPanel">
    <x-shared.stats :stats="$stats" :maxStatValues="$maxStatValues" containerClasses="" />
</div>