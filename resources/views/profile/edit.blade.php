@extends('layouts/forum_layout')
@section('content')
@auth
@if(Auth::user()->id == $user->id)
<link rel="stylesheet" href="{{asset('css/edit.css')}}">
<div id="container">
    <form id="updateProfile">
        <img id="profilepic" src="{{base64_decode($user->avatar)}}" />
        <input id="pic" type="file" />
        <div id="settings">
            <div id="namechanger">
                <h1 class="option">Profile Name </h1>
                <input class="value" id="usernameInput" type="text" placeholder="{{$user->name}}" />
            </div>
            <div class="dropdown-container setting">
                <div class="dropdown">
                    <h1 class="option"> Rank </h1>
                    @php
                    $display = "";
                    $id = -1;
                    $rank = App\Models\Rank::find($user->rank);
                    if($rank != null) {
                    $display = $rank->name;
                    $id = $rank->id;
                    } else {
                    $settings = App\Models\Settings::first();
                    if($settings != null) {
                    $spaghetti = $settings->default_rank;
                    $rank = App\Models\Rank::find($spaghetti);
                    if($rank != null) {
                    $display = "Default: " . $rank->name;
                    $id = $rank->id;
                    }
                    }
                    }
                    @endphp
                    <button rankId="{{$id}}" class="selected-rank value btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{$display}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($ranks as $r)
                        @if(App\Models\Settings::first()->default_rank == $r->id)
                        <a id="{{$r->id}}" class="dropdown-item" href="#"> Default: {{$r->name}} </a>
                        @else
                        <a id="{{$r->id}}" class="dropdown-item" href="#"> {{$r->name}} </a>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <button id="update"> UPDATE </button>
    </form>
</div>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="userId" content="{{$user->name}}">
<meta name="color" content="{{$color}}">
<script src="{{asset('js/app.js')}}" charset="utf-8"></script>
<script src="{{asset('js/profile_edit.js')}}"> </script>
@else
<h1> You do not have priveleges to edit this profile. </h1>
@endif
@else
<h1> You do not have priveleges to edit this profile. </h1>
@endauth
@stop