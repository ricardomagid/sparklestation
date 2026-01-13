<div class="mx-auto panel-base h-[85%] w-[65%] flex border-red-800/70 bg-itemPanel absolute right-5 top-5 bottom-5 p-5 panel-enter gap-3 right-panel panel-hidden" data-panel="traces">
    <div class="relative w-full h-full flex flex-col overflow-hidden">
        <div>
            <h1 class="text-3xl font-bold text-red-100">Traces</h1>
            <div class="w-24 h-1 bg-gradient-to-r from-transparent via-red-400 to-transparent mt-2"></div>
        </div>

        <div class="aspect-[4/5] w-[min(100%,600px)] max-h-full self-center smooth-transition">
            <div id="traceDiagramBackground" class="w-full h-full bg-contain bg-no-repeat bg-center">
                <div id="traceDiagram" class="w-full h-full relative" data-path="{{ $character->path->name }}"
                    data-character-name="{{ $character->slug }}">
                </div>
            </div>
        </div>
    </div>

    <div id="sidePanel"
        class="hidden flex flex-col h-full w-80 p-5 bg-gradient-to-br from-red-900/95 to-red-800/95 backdrop-blur-sm border border-red-700/50 rounded-lg shadow-2xl">

        <div class="flex-1 overflow-y-auto overflow-x-hidden min-h-0">
            <h2 id="circleTitle" class="text-xl font-bold text-red-100 mb-2 border-b border-red-600 pb-2"></h2>
            <div class="flex items-center py-3 rounded-lg" id="circleSlider">
                <span class="text-white text-sm mr-3 w-20">Level: <span class="ability-slider-number"></span></span>
                <input type="range" min="1" value="1"
                    class="ability-slider trace-slider h-2 flex-grow appearance-none rounded-lg bg-red-500/50 accent-red-600">
            </div>
            <div id="circleTraces" class="flex flex-col gap-4 mt-4"></div>
        </div>

        <div class="h-[30%] border-t border-red-700/50 pt-3 mt-2 overflow-y-auto overflow-x-hidden min-h-0"
            id="traceMaterialsPanel">
            <div class="grid grid-cols-2 gap-4 justify-items-center">
                <!-- Material content goes here -->
            </div>
        </div>
    </div>
</div>