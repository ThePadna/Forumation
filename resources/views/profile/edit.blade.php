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
<button id="update"> UPDATE </button>
</form>
</div>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="userId" content="{{$user->id}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/profile_edit.js')}}"> </script>
@else
<h1> You do not have priveleges to edit this profile. </h1>
@endif
@else
<h1> You do not have priveleges to edit this profile. </h1>
@endauth
@stop