@extends('layout.app')
@section('extra-css')
    @vite('resources/css/character.css')
@endsection
@section('content')
    <x-characters.layouts.show-desktop :character="$character" :stats="$stats" :maxStatValues="$maxStatValues" :storyParts="$storyParts" />
    <x-characters.layouts.show-mobile :character="$character" :stats="$stats" :maxStatValues="$maxStatValues" :storyParts="$storyParts" />

    {{-- Modal for Pictures --}}
    <x-modal.picture />

    <script>
        const statsTable = @json($character->getStatsTable());
        const maxStatValues = @json($maxStatValues);
        const levelUpMats = @json($character->getLevelUpMaterials());

        window.characterData = {
            traces: @json($character->traces),
            traceMaterials: @json($character->trace_materials),
            groupedAbilities: @json($character->grouped_abilities),
            abilityValues: {
                @foreach ($character->abilities as $ability)
                    {{ $ability->id }}: [
                        @json($ability->differences),
                        @json($ability->positions)
                    ],
                @endforeach
            }
        };
    </script>
@endsection
