@extends('layout.app')
@section('extra-css')
    @vite('resources/css/lightcone.css')
@endsection
@section('content')
    <div id="lightconeContent">
        <x-lightcones.layouts.show-desktop :lightcone="$lightcone" :stats="$stats" :maxStatValues="$maxStatValues" />
        <x-lightcones.layouts.show-mobile :lightcone="$lightcone" :stats="$stats" :maxStatValues="$maxStatValues" />
    </div>

    {{-- Modal for Pictures --}}
    <x-modal.picture />

    <script>
        const statsTable = @json($lightcone->getStatsTable());
        const maxStatValues = @json($maxStatValues);
        const levelUpMats = @json($lightcone->getLevelUpMaterials());
        const skillValues = @json($lightcone->getSkillValues());
    </script>
@endsection
