<div class="bg-itemPanel p-4">
    <div class="pt-3">
        @if ($skill)
            <!-- Skill Header -->
            <div class="flex items-center mb-2 border-b border-white/15 pb-2">
                <div>
                    <h2 class="text-xl font-bold text-white">{{ $skill->name }}</h2>
                </div>
            </div>

            <!-- Skill Description -->
            <div class="bg-white/5 rounded-lg p-4">
                <h3 class="text-red-300 mb-1 text-sm font-medium uppercase tracking-wide">Description
                </h3>
                <p class="text-white text-[15px] leading-relaxed skill-description"
                    data-base-numbers='@json($skill->base_numbers)'>
                    {!! $skill->description ?? 'No description available.' !!}
                </p>
            </div>

            <!-- Skill Slider -->
            <div class="flex items-center mb-6 bg-black/15 p-3 rounded-lg mt-4">
                <span class="text-white text-sm mr-3 w-20">Level: <span class="skill-slider-number">1</span></span>
                <input type="range" min="1" max="5" value="1"
                    class="skill-slider h-2 flex-grow appearance-none rounded-lg bg-red-800/50 accent-red-600">
            </div>
        @endif
    </div>
</div>
