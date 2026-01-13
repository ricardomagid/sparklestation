<div class="timeline-card-wrapper absolute" style="left: {{ $xPosition }}%;">
    <div class="timeline-card-shrink">
        <div class="timeline-card rounded-xl cursor-pointer glow-effect card-background group"
            onclick="openTimelineModal('{{ $patch->id }}')" style="background-image: url('{{ asset($patch->img) }}')"
            data-storyarc="{{ $patch->storyArc->img }}">

            <div class="card-overlay absolute inset-0 rounded-xl"></div>
            <div class="card-content-overlay"></div>

            <div class="absolute top-3 right-3 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                onclick="event.stopPropagation(); openImageModal('{{ $patch->img }}')">
                <div
                    class="bg-black/50 backdrop-blur-sm p-2 rounded-full border border-white/30 hover:bg-black/70 transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </div>
            </div>

            <div class="relative z-10 p-6 h-full flex flex-col justify-between timeline-card-content">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <h3 class="timeline-patch-number text-3xl font-black">{{ $patch->formatted_number }}</h3>
                        <div class="bg-red-500/20 backdrop-blur-sm px-3 py-1 rounded-full border border-red-500/30">
                            <span class="text-red-300 text-xs font-semibold">{{ $isLast ? 'LIVE' : '' }}</span>
                        </div>
                    </div>

                    <h4 class="text-white text-lg font-bold tracking-wide drop-shadow-lg timeline-patch-name">
                        {{ $patch->name }}
                    </h4>
                </div>

                <div class="flex items-end justify-between">
                    <div class="space-y-1">
                        <p class="text-gray-300 text-sm font-medium">Duration</p>
                        <p class="text-white text-lg font-bold">{{ $patch->formatted_duration }}</p>
                    </div>
                </div>

                <div
                    class="absolute inset-0 rounded-xl bg-gradient-to-br from-red-500/20 via-transparent to-purple-500/20 pointer-events-none">
                </div>
            </div>
        </div>
    </div>
</div>
