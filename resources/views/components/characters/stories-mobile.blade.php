<div class="mx-auto panel-base panel-enter right-panel panel-hidden bg-itemPanel backdrop-blur-sm shadow-lg border border-white/10 overflow-hidden"
    data-panel="story">
    <!-- Story Content -->
    <div class="space-y-4 overflow-auto h-full pb-6 p-2">
        @foreach ($storyParts as $index => $part)
            <div class="story-container group">
                <!-- Story Card Header -->
                <div
                    class="bg-black/15 hover:bg-black/25 rounded-lg p-4 transition-all duration-300 border border-white/10 hover:border-red-500/30">
                    <div class="flex items-center justify-between story-clickable cursor-pointer">
                        <div class="flex items-start gap-4 flex-1">
                            <!-- Story Title -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white group-hover:text-red-300 transition-colors">
                                    {{ $part['story'] }}
                                </h3>
                                <p class="text-white/60 text-sm mt-1">Click to read</p>
                            </div>
                        </div>

                        <!-- Expand Arrow -->
                        <svg class="arrow w-5 h-5 text-red-400 transform transition-all duration-300 flex-shrink-0 group-hover:text-red-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                <!-- Story Description -->
                <div class="hidden mt-4" data-story="{{ $part['story'] }}">
                    <div class="bg-white/5 rounded-lg p-6 border-l-4 border-red-500/50">
                        <p class="text-white text-[15px] leading-relaxed">{{ $part['description'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
