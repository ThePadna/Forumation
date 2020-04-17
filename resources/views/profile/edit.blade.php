@extends('layouts/forum_layout')
@section('content')
@auth
@if(Auth::user()->id == $user->id)
<link rel="stylesheet" href="{{asset('css/edit.css')}}">
<div id="container">
    <form id="updateProfile">
        <img id="profilepic" src="{{base64_decode($user->avatar)}}" />
        <input id="pic" type="file" />
        <div id="namechanger">
            <h1> Profile Name </h1>
            <input id="usernameInput" type="text" placeholder="{{$user->name}}" />
        </div>
        <div class="dropdown-container">
            <div class="dropdown">
                <h1> Rank </h1>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Moderator
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
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