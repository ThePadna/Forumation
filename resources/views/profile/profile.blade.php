@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<div id="profile-header">
    @php
    $rank = null;
    $ban = false;
    $edit = false;
    $editown = false;
    $settings = App\Models\Settings::first();
    if(Auth::check()) {
    $rank = Auth::user()->rank;
    if($rank == null) {
    if($settings != null) {
    $default = $settings->default_rank;
    $rank = App\Models\Rank::find($default);
    }
    }
    if($rank != null) {
    $rank = App\Models\Rank::find($rank);
    $perms = unserialize($rank->permissions);
    if(in_array('editotherprofile', $perms)) $edit = true;
    if(in_array('banuserprofile', $perms)) $ban = true;
    if(in_array('usereditownprofile', $perms)) $editown = true;
    }
    }
    $profileRank = App\Models\Rank::find($user->rank);
    if($profileRank == null) {
    if($settings != null) {
    $default = $settings->default_rank;
    $profileRank = App\Models\Rank::find($default);
    }
    }
    @endphp
    @if($ban && Auth::user()->id != $user->id)
    <p id="ban-btn"> <i class="fas fa-ban"></i> Ban User </p>
    @endif
    @if($edit || $editown)
    <a href="/forum/profile/{{$user->name}}/edit">
        <p id="edit-btn"> [Edit Profile] </p>
    </a>
    @endif
    <div id="avatar-container">
        @if($user->avatar == null)
        <img id="avatar" src="{{asset('default_avatar.png')}}" />
        @else
        <img id="avatar" src="{{base64_decode($user->avatar)}}" />
        @endif
    </div>
    <div id="profile-name-container">
        <h1 id="profile-name"> {{$user->name}} </h1>
    </div>
    @if($profileRank != null)
    <div id="rank-container">
        <p id="rank" style="color: {{$profileRank->color}}"> {{$profileRank->name}} </p>
    </div>
    @endif
</div>
<div id="container">
    <div class="row">
        <div id="posts" class="col-sm-4">
            <h1 class="title"> Posts </h1>
            <p id="posts-counter" class="counter"> {{$posts}} </p>
        </div>
        <div id="threads" class="col-sm-4">
            <h1 class="title"> Threads </h1>
            <p id="threads-counter" class="counter"> {{$threads}} </p>
        </div>
        <div id="score" class="col-sm-4">
            <h1 class="title"> Score </h1>
            <p id="score-counter" class="counter"> {{$score}} </p>
        </div>
    </div>
</div>
<meta name="color" content="{{$color}}">
<meta name="threads" content="{{$threads}}">
<meta name="posts" content="{{$posts}}">
<meta name="score" content="{{$score}}">
<meta name="user" content="{{$user->name}}">
<script src="{{asset('js/app.js')}}" charset="utf-8"></script>
<script src="{{asset('js/profile.js')}}"> </script>
@stop