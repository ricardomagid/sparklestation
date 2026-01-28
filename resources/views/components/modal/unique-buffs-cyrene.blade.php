@vite('resources/css/unique-buffs-cyrene.css')
<div id="uniqueBuffsModal"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 justify-center items-center modal-enter-active modal-leave-active opacity-0 transform scale-95"
    onclick="closeUniqueBuffsModal()">

    <div id="uniqueBuffsCyreneModal" class="bg-no-repeat bg-cover bg-center w-[90%] h-[90%]"
        style="background-image: url('{{ asset($character->unique_buffs_modal_img) }}')"
        onclick="event.stopPropagation()">
        @foreach ($character->unique_buff_targets_list as $target)
            <div class="selector @if ($loop->last) selected @endif absolute flex flex-col items-center">
                <div class="selector-icon z-10"> <img src="{{ $character->uniqueBuffTargetIcon($target['slug']) }}"
                        alt="Character Icon" class="w-20 h-20 max-w-[80px] rounded-full border-2 border-[#e6c78a]">
                </div>

                <div class="selector-cardboard relative -mt-4 flex items-center justify-center"
                    style="--default-img: url('{{ asset($character->unique_buffs_selector_img) }}'); 
            --selected-img: url('{{ asset($character->unique_buffs_selector_selected_img) }}');">

                    <p class="selector-text relative z-10 w-full text-center font-bold text-white pointer-events-none">
                        {{ $target['name'] }}
                    </p>
                </div> 
            </div>

            <div class="unique-buff-card @if (!$loop->last) hidden @endif">
                <img src="{{ asset($character->uniqueBuffTargetCard($target['slug'])) }}" alt="Buff Card">
            </div>

            <div class="buff-title @if (!$loop->last) hidden @endif">
                <p>{{ $target['buff_title'] }}</p>
            </div>

            <div class="buff-description @if (!$loop->last) hidden @endif">
                <p>{!! $target['buff_description'] !!}</p>
            </div>
        @endforeach
    </div>


    <button onclick="closeTimelineModal()"
        class="absolute top-4 right-4 bg-black/50 backdrop-blur-sm p-2 rounded-full border border-white/30 hover:bg-black/70 transition-colors z-10 hover:scale-110">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
