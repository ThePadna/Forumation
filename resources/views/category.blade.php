@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/category.css')}}">
<div id="wrapper">
    @auth
    <a href="post">
        <div id="postThread">
            <h1> Post a new thread </h1>
        </div>
    </a>
    @endauth
    <div id="threads">
        @foreach($threads as $t)
        <a href="/threads/{{$t->id}}">
            <div id="thread">
                <div id="title">
                    <p> {{$t->title}}</p>
                </div>
                <div id="op">
                    <p> Latest post by &nbsp; <i class="far fa-user"></i> {{$t->op}} x ago </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @if($page > 1)
    <a href="{{$page < 2 ? 1 : $page - 1}}">
        <div id="prevpage">
            <i class="fas fa-long-arrow-alt-left"></i>
        </div>
    </a>
    @endif
    <a href="{{$page + 1}}">
        <div id="nextpage">
            <i class="fas fa-long-arrow-alt-right"></i>
        </div>
    </a>
</div>
@stop