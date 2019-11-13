@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<div id="profileheader">
    <img src="{{asset('img/profilepic.png')}}" />
    <h1> {{$user->name}} </h1>
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
@stop