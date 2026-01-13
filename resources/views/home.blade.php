@extends('layout.app')
@section('content')
    <div class="text-gray-200 min-h-screen pt-5 pb-10" id="homeContent">

        <div class="mt-10 flex flex-col items-center text-center space-y-3 smooth-transition">
            <h3
                class="font-extrabold text-4xl text-ruby drop-shadow-[0_0_10px_rgba(255,0,0,0.4)] transition-transform hover:scale-[1.02]">
                Sparkle Station
            </h3>
            <p class="text-black text-lg max-w-md">Track Characters, Compare Relics and Test your Luck!</p>
        </div>

        <div class="mt-10 flex flex-col items-center">
            <div
                class="flex flex-col items-center bg-[#FFB9B9] border border-red-700/30 rounded-2xl shadow-md shadow-red-900/40 p-6 w-11/12 md:w-4/5 transition-all hover:shadow-red-700/50 text-black">
                <p class="text-2xl font-bold text-ruby mb-5 text-center">Current Patch</p>

                @if ($currentPatch)
                    <x-patch.table-desktop :patch="$currentPatch" :characters="$characters" />
                    <x-patch.table-mobile :patch="$currentPatch" :characters="$characters" />

                    <div class="mt-6 text-center">
                        <p class="text-lg font-semibold text-ruby mb-2">
                            Next Update In:
                        </p>

                        <div class="bg-mauve/60 rounded-lg px-6 py-3 inline-block border border-red-700/20">
                            <span id="nextPatch" class="text-xl font-bold text-ruby">
                                -- days -- hours -- minutes
                            </span>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('patches') }}"
                            class="text-red-600 hover:text-red-400 transition-colors font-medium underline underline-offset-4">
                            See other patches
                        </a>
                    </div>
                @else
                    <div class="text-center">
                        There are no patches to show.
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-10 flex items-center justify-center">
            <div
                class="flex flex-col lg:flex-row items-stretch justify-between bg-[#FFB9B9] border border-red-700/30 rounded-2xl shadow-md shadow-red-900/40 p-6 w-11/12 md:w-4/5 transition-all hover:shadow-red-700/50 text-black gap-6">

                <div class="w-full lg:w-1/2 flex flex-col">
                    <p class="text-2xl font-bold text-ruby mb-5 text-center lg:text-left">
                        Character Spotlight
                    </p>

                    <div class="flex-1 rounded-xl p-5 shadow-inner shadow-red-900/20 bg-\[\#FFB9B9\]">
                        <div class="flex flex-col items-center lg:items-start h-full">
                            <p class="text-xl font-semibold mb-4 text-center lg:text-left text-ruby">
                                {{ $randomCharacter->name }}</p>

                            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 mb-5">
                                <a href="{{ route('characters.show', $randomCharacter->id) }}" class="flex-shrink-0">
                                    <img src="{{ $randomCharacter->icon_img }}" alt="{{ $randomCharacter->name }}"
                                        title="{{ $randomCharacter->name }}"
                                        class="w-24 h-28 rounded-xl shadow-lg shadow-red-900/40 hover:scale-105 transition-transform border-2 border-red-400/30">
                                </a>

                                <p class="text-sm text-black leading-relaxed text-center sm:text-left">
                                    {{ $randomCharacter->getFormattedStoryParts()[0]['description'] }}
                                </p>
                            </div>

                            <div class="mt-auto w-full flex justify-center lg:justify-start">
                                <a href="{{ route('characters.show', $randomCharacter->id) }}">
                                    <button
                                        class="px-6 py-2.5 bg-ruby text-white font-semibold rounded-xl shadow-md shadow-red-900/40 hover:bg-red-600 hover:scale-[1.03] transition-all">
                                        Learn More →
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex flex-col">
                    <p class="text-2xl font-bold text-ruby mb-5 text-center lg:text-left">
                        Active Codes
                    </p>

                    <div class="flex-1 bg-\[\#FFB9B9\] rounded-xl p-5 shadow-inner shadow-red-900/20">
                        @if (count($activeCodes) > 0)
                            <div class="grid grid-cols-2 gap-3">
                                @foreach ($activeCodes as $code)
                                    <a href="https://hsr.hoyoverse.com/gift?code={{ $code->name }}" class="block"
                                        target="_blank" rel="noopener noreferrer">
                                        <button
                                            class="w-full px-3 py-3 bg-white text-red-600 font-semibold text-sm border-2 border-red-400 rounded-xl shadow-md shadow-red-900/30 hover:bg-red-50 hover:border-red-500 hover:scale-[1.02] transition-all break-all">
                                            {{ $code->name }}
                                        </button>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="flex items-center justify-center h-full text-center text-gray-600">
                                <p>No active codes available at the moment.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="mt-10 flex flex-col items-center justify-center">
            <div
                class="bg-[#FFB9B9] border border-red-700/30 rounded-2xl shadow-md shadow-red-900/40 p-6 w-11/12 md:w-4/5 transition-all hover:shadow-red-700/50">
                <p class="text-2xl font-bold text-ruby text-center mb-5">Current Statistics</p>

                @if (count($characters) > 0)
                    <div class="w-full mt-4 flex flex-col items-center md:flex-row md:justify-between md:space-x-4">
                        <div
                            class="chart-wrapper relative p-4 rounded-2xl shadow-inner shadow-red-900/30 hover:shadow-red-700/40 transition-transform hover:scale-[1.02] w-full md:w-[48%] max-w-[20em] mb-6 md:mb-0">
                            <canvas class="pie-chart" id="elementChart"></canvas>
                        </div>
                        <div
                            class="chart-wrapper relative p-4 rounded-2xl shadow-inner shadow-red-900/30 hover:shadow-red-700/40 transition-transform hover:scale-[1.02] w-full md:w-[48%] max-w-[20em]">
                            <canvas class="pie-chart" id="pathChart"></canvas>
                        </div>
                    </div>

                    <div
                        class="chart-wrapper relative p-4 rounded-2xl shadow-inner shadow-red-900/30 hover:shadow-red-700/40 transition-transform hover:scale-[1.02] w-full md:mt-6 max-w-[16em] mx-auto">
                        <canvas class="pie-chart" id="genderChart"></canvas>
                    </div>
                @else
                    <div class="text-center text-black">
                        There are no statistics to show.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal for Pictures --}}
    <x-modal.picture />

    <script>
        const charts = {!! json_encode($charts) !!};
    </script>
@endsection
