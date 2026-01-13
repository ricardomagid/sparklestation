{{-- Modal for Pictures --}}
<div class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 justify-center items-center modal-enter-active modal-leave-active opacity-0 transform scale-95"
    id="imageModal" onclick="closeImageModal()">
    <div class="w-full h-full p-[10%] flex justify-center items-center pointer-events-none">
        <img id="modalImage" class="max-w-full max-h-full pointer-events-auto" alt="Picture">
    </div>

    <button onclick="closeTimelineModal()"
        class="absolute top-4 right-4 bg-black/50 backdrop-blur-sm p-2 rounded-full border border-white/30 hover:bg-black/70 transition-colors z-10 hover:scale-110">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
