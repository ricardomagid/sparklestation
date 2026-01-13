<div class="mx-auto panel-base w-[65%] h-[85%] absolute right-5 top-5 bottom-5 p-5 panel-enter gap-4 right-panel panel-hidden" data-panel="story">
    <div class="h-full grid grid-rows-[70%_30%]">
        {{-- Story Description Section --}}
        <div id="currentStoryDescription" class="flex justify-center p-4 h-auto overflow-auto">
            <div class="story-card max-w-4xl transition-opacity duration-300"
                id="storyBlock0">
                <div class="bg-red-700 rounded-t-lg story-header transition-transform duration-300 p-6">
                    <p class="p-header-clicked">
                        {{ $storyParts[0]['story'] }}
                    </p>
                </div>
                <div class="p-6 bg-itemPanel story-description rounded-b-lg">
                    <p class="text-white text-base leading-relaxed">
                        {{ $storyParts[0]['description'] }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Story Cards Section --}}
        <div class="grid grid-cols-3 gap-6 p-5 story-card-list">
            @foreach ($storyParts as $index => $part)
                @if ($loop->first)
                    @continue
                @endif
                <div class="story-card cursor-pointer transition-opacity duration-300"
                    id="storyBlock{{ $index }}">
                    <div class="bg-red-700 p-4 transition-opacity duration-300 rounded-t-lg story-header">
                        <p class="p-header">
                            {{ $part['story'] }}
                        </p>
                    </div>
                    <div class="hidden p-6 story-description bg-itemPanel rounded-b-lg">
                        <p class="text-white text-base leading-relaxed">
                            {{ $part['description'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
