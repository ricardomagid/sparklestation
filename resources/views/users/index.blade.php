@extends('layout.app')
@section('extra-css')
    @vite('resources/css/user.css')
@endsection
@section('content')
    <div id="userContent">
        @php
            $userJson = json_encode(
                auth()
                    ->user()
                    ->only(['id', 'username', 'email', 'role', 'img']),
            );
        @endphp


        <div id="userApp" data-user='{{ $userJson }}'></div>
    </div>
@endsection
