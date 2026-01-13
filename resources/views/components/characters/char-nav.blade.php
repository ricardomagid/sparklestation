@if($format=="desktop")
    <div class="char-nav fixed bottom-8 left-1/2 flex justify-center gap-4 rounded-xl px-6 py-3 bg-[#b12a2a] shadow-[0_4px_20px_rgba(0,0,0,0.25)] transform -translate-x-1/2">
@else
    <div class="char-nav flex justify-between w-full px-2 py-3 bg-[#b12a2a] shadow-[0_4px_20px_rgba(0,0,0,0.25)]">
@endif
    <div class="tab active">
        <span>Overview</span>
    </div>

    <div class="tab flex-1 text-center">
        <span>Skills</span>
    </div>

    <div class="tab flex-1 text-center">
        <span>Traces</span>
    </div>

    <div class="tab flex-1 text-center">
        <span>Eidolons</span>
    </div>

    <div class="tab flex-1 text-center">
        <span>Story</span>
    </div>
</div>
