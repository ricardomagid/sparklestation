{{-- Loading State --}}
<div id="modalLoading"
    class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 justify-center items-center modal-enter-active modal-leave-active opacity-0 transform scale-95">
    <div class="flex flex-col items-center gap-4">
        <div class="animate-spin rounded-full h-14 w-14 border-b-2 border-white"></div>
        <p class="text-white text-lg drop-shadow-[0_2px_4px_rgba(0,0,0,0.9)]">{{ $loading ?? 'Loading...' }}</p>
        <button id="stopFetchBtn" onClick="stopFetch()" class="mt-4 px-4 py-2 bg-red-600 rounded text-white hover:bg-red-700">
            Stop
        </button>
    </div>
</div>
