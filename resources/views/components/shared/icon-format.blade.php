<div class="mt-4 flex flex-wrap justify-center gap-4 items-center item-section mb-2">
    @foreach ($items as $i)
        <x-shared.item-icon :i="$i" :isCharacter="$isCharacter" />
    @endforeach

    <x-shared.pop-up-table :enableWallpaper="true" :rows="[
        'Name' => 'Name',
        'Path' => 'Path',
        'Element' => 'Element',
        'Faction' => 'Faction',
    ]" />
</div>
