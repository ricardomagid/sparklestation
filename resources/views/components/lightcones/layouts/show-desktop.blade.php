<div class="hidden xl:block m-10" id="app-desktop" data-layout="desktop">
    <div class="flex gap-6 justify-between">
        <x-lightcones.details-desktop :lightcone="$lightcone" />
        <x-shared.stats :stats="$stats" :maxStatValues="$maxStatValues" containerClasses="flex-shrink-0 w-80" />
    </div>

    <div class="mt-4">
        <x-lightcones.skill :skill="$lightcone->skill ?? null" />
    </div>
</div>
