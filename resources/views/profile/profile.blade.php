@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<div id="profile-header">
    @php
    $settings = App\Models\Settings::first();
    $default = $settings->default_rank;
    $rank = null;
    if(Auth::check()) $rank = Auth::user()->getRank();
    $profileRank = App\Models\Rank::find($user->rank);
    if($profileRank == null) {
    if($settings != null) {
    $default = $settings->default_rank;
    $profileRank = App\Models\Rank::find($default)->first();
    }
    }
    @endphp
    @if($rank != null && $rank->hasPerm("ban") && Auth::user()->id != $user->id)
    <p id="ban-btn"> <i class="fas fa-ban"></i> Ban User </p>
    @endif
    @if($rank != null && $rank->hasPerm("editotherprofile") || $rank->hasPerm("editownprofile"))
    <a href="/forum/profile/{{$user->name}}/edit">
        <p id="edit-btn"> [Edit Profile] </p>
    </a>
    @endif
    <div id="avatar-container">
        @if($user->avatar == null)
        <img id="avatar" src="{{asset('img/default_avatar.png')}}" />
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
    @if($rank != null && $rank->hasPerm("sendmessage"))
    <div id="send-message">
        <i class="send-message-btn fas fa-paper-plane"></i>
        <p class="send-message-header"> Message </p>
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