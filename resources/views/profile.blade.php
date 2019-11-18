@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<div id="profileheader">
    <a href="/forum/profile/{{$user->id}}/edit"> <p id="editBtn"> [Edit Profile] </p> </a>
    <div id="profilepicdiv">
        <img id="profilepic" src="{{asset('img/profilepic.png')}}" />
    </div>
    <div id="profilenamediv">
            <h1> {{$user->name}} </h1>
    </div>
</div>
<div id="container">
    <div class="row">
        <div class="col-sm-4">
            <h1 class="title"> Posts </h1>
            <p class="counter"> 50 </p>
        </div>
        <div class="col-sm-4">
            <h1 class="title"> Threads </h1>
            <p class="counter"> 50 </p>
        </div>
        <div class="col-sm-4">
            <h1 class="title"> Score </h1>
            <p class="counter"> 50 </p>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
@auth
@if(Auth::user()->id == $user->id)
<script src="{{asset('js/profile_auth.js')}}"> </script>
<meta name="username" content="{{$user->name}}">
@endif
@endauth
@stop