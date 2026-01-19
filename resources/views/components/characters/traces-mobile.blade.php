<div class="panel-base flex flex-col border-red-800/70 bg-itemPanel p-5 panel-enter gap-3 right-panel panel-hidden overflow-hidden"
    data-panel="traces">
    <div class="w-full">
        <h1 class="text-3xl font-bold text-red-100">Traces</h1>
        <div class="h-1 w-24 mt-2 bg-gradient-to-r from-transparent via-red-400 to-transparent"></div>
    </div>

    <div class="space-y-3">
        @foreach ($character->traces->whereIn('position', [1, 5, 9, 13]) as $trace)
            <div
                class="relative bg-black/20 border border-red-500/70 rounded-lg hover:bg-black/30 cursor-pointer main-trace-panel p-5"
                data-trace-position="{{ $trace->position }}">

                <div class="flex items-center justify-between">
                    <div class="flex items-start gap-4 flex-1">
                        <img src="{{ $trace->main_trace_img($loop->iteration) }}" alt="{{ $trace->name }}"
                            class="w-16 h-16 object-contain">

                        <div class="flex-1">
                            <p class="text-lg font-semibold text-white">{{ $trace->name }}</p>
                            <p class="text-sm text-white/80 leading-relaxed">{{ $trace->description }}</p>
                        </div>
                    </div>

                    <!-- Arrow positioned within the header -->
                    @if($trace->position != 13)
                        <svg class="arrow w-5 h-5 text-red-400 transform transition-transform duration-300 flex-shrink-0"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    @endif
                </div>

                <!-- Materials -->
                <div class="hidden flex-wrap gap-3 justify-center mt-4 bg-black/20 p-3 rounded-b-lg mobile-trace-mat-container"
                    data-trace-id="trace{{ $trace->position }}">
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex flex-wrap gap-4 justify-center">
        @foreach ($character->total_minor_traces as $stat => $value)
            <div
                class="flex flex-col items-center bg-black/20 p-3 rounded-lg border border-red-500/50 w-24 text-center hover:bg-black/30 transition">
                <img src="{{ asset('images/traces/' . $character->total_minor_traces_imgs[$stat]) }}"
                    alt="{{ $stat }}" class="w-14 h-14 object-contain mb-2">
                <p class="text-sm font-medium text-white">{{ $stat }}</p>
                <p class="text-sm text-red-300">{{ $value }}</p>
            </div>
        @endforeach
    </div>

</div>