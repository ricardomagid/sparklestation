<div class="block xl:hidden min-h-screen flex flex-col bg-gradient-to-b from-red-900 via-red-800 to-red-700"
    id="app-mobile" data-layout="mobile">

    <div class="flex-1">
        <!-- Title -->
        <div class="w-full bg-red-800/95 backdrop-blur-sm mt-3 lg:mt-0">
            <h1 class="text-2xl font-bold text-center text-white py-4">{{ $lightcone->name }}</h1>
        </div>

        <!-- Details Section -->
        <x-lightcones.details-mobile :lightcone="$lightcone"
            containerClasses="shadow-lg rounded-lg overflow-hidden" />

        <!-- Stats Section -->
        <x-lightcones.stats-mobile :maxStatValues="$maxStatValues" :stats="$stats" />
        <!-- Skill Section -->
        <div class="mt-6">
            <div class="bg-darkerItemPanel text-[#FFD1D1] text-center py-2">
                <h2 class="text-lg font-semibold tracking-wide">Skill</h2>
            </div>
            <x-lightcones.skill :skill="$lightcone->skill ?? null" />
        </div>
    </div>
</div>
