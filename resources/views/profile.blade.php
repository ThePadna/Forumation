@extends('layouts/forum_layout')
@section('content')
<div id="profile_header">
    <img src="{{asset('img/profilepic.png')}}" />
    <h1> {{$user->name}} </h1>
</div>
@stop