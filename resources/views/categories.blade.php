<html>
@extends('layouts/forum_layout')
@section('content')
<head>
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
</head>
<div id="wrapper">
<div id="categories">
@if(sizeof($categories) < 1)
<h1> No Categories found. </h1>
<div id="footer">
    <div class="row">
        <div class="col-sm-3">
            <a href="https://github.com/ThePadna/Forumation">
                <i class="fa fa-file-code"></i>
                <p> Source </p>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="/faq">
                <i class="far fa-question-circle"></i>
                <p> F.A.Q. </p>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="/forum">
                <i class="fas fa-laptop"></i>
                <p> Demo </p>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="/guide">
                <i class="fas fa-info"></i>
                <p> Guide </p>
            </a>
        </div>
    </div>
</div>
@else
@foreach($categories as $c)
<a href="/category/{{$c->id}}">
<div id="category">
<div id="name">
<p> {{$c->name}}</p>
</div>
</div>
</a>
@endforeach
@endif
@auth
@if(Auth::user()->role == "admin")

@endif
@endauth
@stop
</html>