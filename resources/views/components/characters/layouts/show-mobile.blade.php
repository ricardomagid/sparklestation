<div class="block xl:hidden flex flex-col bg-gradient-to-b from-red-900 to-red-800"
    id="app-mobile" data-layout="mobile">
    
    <div class="w-full bg-red-800/95 backdrop-blur-sm mt-3 lg:mt-0">
        <h1 class="text-2xl font-bold text-center text-white py-4">{{ $character->name }}</h1>
    </div>

    <!-- Navigation Panel -->
    <x-characters.char-nav format="mobile" />

    <!-- Overview Panel -->
    <x-characters.overview :character="$character" :stats="$stats" :maxStatValues="$maxStatValues" containerClasses="" />

    <!-- Skills Panel -->
    <x-characters.skills :character="$character" format="mobile" />

    <!-- Traces Panel -->
    <x-characters.traces-mobile :character="$character" />

    <!-- Eidolons Panel -->
    <x-characters.eidolons :character="$character" format="mobile" />

    <!-- Story Panel -->
    <x-characters.stories-mobile :storyParts="$storyParts" />
</div>