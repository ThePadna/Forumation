@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<div id="profileheader">
    <img src="{{asset('img/profilepic.png')}}" />
    <h1> {{$user->name}} </h1>
</div>
<div id="navwrapper">
    <div id="nav">
        <button id="postsBtn"> Posts </button>
        <button id="threadsBtn"> Threads </button>
    </div>
</div>
@stop