@php
use Carbon\Carbon;

$reversedPatches = $patches->reverse();
$totalDays = max(1, $reversedPatches->sum('duration'));
$gapDays = 75; // gap between patches
$usablePercent = 80; // timeline uses 10%..90% (80% span)
$offsetPercent = 10;

$currentDays = 0;
$positions = [];

foreach ($reversedPatches as $patch) {
    $fraction = $currentDays / $totalDays;
    $x = $fraction * $usablePercent + $offsetPercent;
    $positions[] = ['patch' => $patch, 'x' => $x];
    $currentDays += $patch->duration + $gapDays;
}

$maxXPosition = max($offsetPercent + 1, ($currentDays / $totalDays) * $usablePercent + $offsetPercent);

$initialDay = Carbon::create(2023, 3, 26);
$today = Carbon::today();
$daysSinceStart = min($initialDay->diffInDays($today), $totalDays); // used for "Today pin" which has a maximum distance of 42 days
$todayXPosition = ($daysSinceStart / $totalDays) * ($maxXPosition - $offsetPercent) + $offsetPercent;
@endphp

<div class="hidden" id="timelineFormat">
  <div class="relative text-white h-screen overflow-x-auto" id="scrollContainer">
    <div class="relative h-full timeline-inner" style="width: {{ ($maxXPosition + 20) }}%;">
      <div class="absolute top-1/2 w-full border-b-2 border-red-200 transform -translate-y-1/2"
           style="width: {{ $maxXPosition + 15 }}%; left: 0;"></div>
      <div class="absolute top-1/2 transform -translate-y-1/2 timeline-today-circle"
           style="left: {{ $todayXPosition }}%;"></div>

      @foreach ($positions as $i)
        @php
          $patch = $i['patch'];
          $xPosition = $i['x'];
          $isLast = ($loop->last);
        @endphp

        <div class="timeline-circle" style="left: {{ $xPosition }}%;"></div>
        <x-patch.timeline-card :patch="$patch" :xPosition="$xPosition" :isLast="$isLast" />
      @endforeach
    </div>
  </div>
</div>
