@extends('layouts/forum_layout')
@section('content')
@auth
@if(Auth::user()->id == $user->id)
<link rel="stylesheet" href="{{asset('css/edit.css')}}">
<div id="container">
    <form id="update-profile">
        <img id="avatar" src="{{base64_decode($user->avatar)}}" />
        <input id="avatar-input" type="file" />
        <div id="settings">
            <div id="name-changer">
                <h1 class="option">Profile Name </h1>
                <input autocomplete="off" class="value" id="username-input" type="text" placeholder="{{$user->name}}" />
            </div>
            <div class="dropdown-container setting">
                <div class="dropdown">
                    <h1 class="option"> Rank </h1>
                    @php
                    $display = "";
                    $id = -1;
                    $rank = $user->getRank();
                    if($rank != null) {
                    $display = $rank->name;
                    $id = $rank->id;
                    } else {
                    $spaghetti = $settings->default_rank;
                    $rank = App\Models\Rank::find($spaghetti);
                    if($rank != null) {
                    $display = "Default: " . $rank->name;
                    $id = $rank->id;
                    }
                    }
                    @endphp
                    <button rankId="{{$id}}" class="selected-rank value btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$display}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($ranks as $r)
                        @if($settings->default_rank == $r->id)
                        <a id="{{$r->id}}" class="dropdown-item" href="#"> Default: {{$r->name}} </a>
                        @else
                        <a id="{{$r->id}}" class="dropdown-item" href="#"> {{$r->name}} </a>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="error-container"> </div>
        <button id="update"> UPDATE </button>
    </form>
</div>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="userId" content="{{$user->name}}">
<meta name="color" content="{{$settings->color}}">
<meta name="username-length" content="{{$settings->profile_name_length}}">
<script src="{{asset('js/app.js')}}" charset="utf-8"></script>
<script src="{{asset('js/profile_edit.js')}}"> </script>
@else
<h1> You do not have priveleges to edit this profile. </h1>
@endif
@else
<h1> You do not have priveleges to edit this profile. </h1>
@endauth
@stop