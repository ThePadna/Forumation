@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<div id="profileheader">
    @auth 
    @if(Auth::user()->role == "admin" || Auth::user()->id == $user->id)
    <p id="ban-btn"> <i class="fas fa-ban"></i> Ban User </p>
    <a href="/forum/profile/{{$user->name}}/edit"> <p id="editBtn"> [Edit Profile] </p> </a>
    @endif
    @endauth
    <div id="profilepicdiv">
        @if($user->avatar == null)
        <img id="profilepic" src="{{asset('img/profilepic.png')}}" />
        @else
        <img id="profilepic" src="{{base64_decode($user->avatar)}}" />
        @endif
    </div>
    <div id="profilenamediv">
            <h1> {{$user->name}} </h1>
    </div>
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/profile.js')}}"> </script>
@auth
@if(Auth::user()->id == $user->id)
<script src="{{asset('js/profile_auth.js')}}"> </script>
<meta name="username" content="{{$user->name}}">
@endif
@endauth
@stop