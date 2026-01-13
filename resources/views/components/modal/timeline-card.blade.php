<x-modal.loading-state loading="Loading patch details..." />

{{-- Timeline Details Modal --}}
<div id="timelineModal"
    class="fixed inset-0 z-50 modal-enter-active modal-leave-active bg-opacity-75 opacity-0 transform scale-95 hidden"
    onclick="closeTimelineModal()">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

    <div class="relative w-full h-full flex items-center justify-center p-4">
        <div class="bg-[rgb(122,48,48)] backdrop-blur-xl rounded-2xl border border-gray-700/50 max-w-4xl w-full max-h-[90vh] overflow-hidden shadow-2xl"
            onclick="event.stopPropagation()">

            <div class="relative">
                <div id="modalBackgroundImage" class="h-64 bg-cover bg-center relative">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
                </div>

                <button onclick="closeTimelineModal()"
                    class="absolute top-4 right-4 bg-black/50 backdrop-blur-sm p-2 rounded-full border border-white/30 hover:bg-black/70 transition-colors z-10">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="absolute bottom-6 left-6 right-6 z-10">
                    <div class="flex items-end justify-between">
                        <div>
                            <div class="flex items-center gap-4 mb-2">
                                <span id="modalPatchNumber" class="text-4xl font-black text-white"></span>
                                <div id="modalLiveBadge"
                                    class="bg-red-500/20 backdrop-blur-sm px-3 py-1 rounded-full border border-red-500/30 hidden">
                                    <span class="text-red-300 text-xs font-semibold">LIVE</span>
                                </div>
                            </div>
                            <h2 id="modalPatchName" class="text-2xl font-bold text-white mb-2"></h2>
                            <div class="flex items-center gap-6 text-gray-300">
                                <div>
                                    <span class="text-sm">Duration:</span>
                                    <span id="modalDuration" class="ml-2 font-semibold text-white"></span>
                                </div>
                                <div>
                                    <span class="text-sm">World:</span>
                                    <span id="modalStoryArc" class="ml-2 font-semibold text-white"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 max-h-96 overflow-y-auto">
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-white mb-3">New Characters</h3>
                        <div id="modalCharacters" class="flex flex-wrap gap-2 justify-center"></div>
                    </div>

                    <div class="text-center md:col-span-2">
                        <h3 class="text-lg font-semibold text-white mb-3">New Light Cones</h3>
                        <div id="modalLightcones" class="flex flex-wrap gap-2 justify-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
