@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<div class="profile-container">
<div class="profile-header">
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
    <p class="ban-btn"> <i class="fas fa-ban"></i> Ban User </p>
    @endif
    @if($rank != null && $rank->hasPerm("editotherprofile") || $rank->hasPerm("editownprofile"))
    <a href="/forum/profile/{{$user->name}}/edit">
        <p id="edit-btn"> [Edit Profile] </p>
    </a>
    @endif
    <div class="avatar-container">
        @php 
        $status = $user->isOnline() ? 'green' : 'red';
        @endphp
        <div class="status" style="background: {{$status}}"> </div>
        @if($user->avatar == null)
        <img class="avatar" src="{{asset('img/default_avatar.png')}}" />
        @else
        <img class="avatar" src="{{base64_decode($user->avatar)}}" />
        @endif
    </div>
    <div class="profile-name-container">
    @if($rank != null && $rank->hasPerm("sendmessage"))
        <i class="send-message-btn fas fa-paper-plane"></i>
    @endif
        <h1 class="profile-name"> {{$user->name}} </h1>
    </div>
    @if($profileRank != null)
    <div class="rank-container">
        <h1 class="rank"> {{strtoupper($profileRank->name)}} </p>
    </div>
    @endif
    <div class="user-since">
        <h1> User since {{Carbon\Carbon::parse($user->created_at)->format('d-m-y')}} </p>
    </div>
</div>
</div>
<div class="container">
    <div class="posts">
        <h1 class="title"> Posts </h1>
        <p id="posts-counter" class="counter"> {{$posts}} </p>
    </div>
    <div class="threads">
        <h1 class="title"> Threads </h1>
        <p id="threads-counter" class="counter"> {{$threads}} </p>
    </div>
    <div class="score">
        <h1 class="title"> Score </h1>
        <p id="score-counter" class="counter"> {{$score}} </p>
    </div>
</div>
<meta name="color" content="{{$color}}">
<meta name="threads" content="{{$threads}}">
<meta name="posts" content="{{$posts}}">
<meta name="score" content="{{$score}}">
<meta name="user" content="{{$user->name}}">
<script src="{{asset('js/profile.js')}}"> </script>
@stop