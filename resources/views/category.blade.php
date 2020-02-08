@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/category.css')}}">
<div id="wrapper">
    <div id="threads">
        @foreach($threads as $t)
        <a href="thread/{{$t->id}}/1">
            <div class="thread">
                <div class="row">
                    <div id="posts" class="col-sm-8">
                        <h1 class="title"> {{$t->title}} </h1>
                        <div class="op">
                    @php
                    $id = $t->id;
                    $time = null;
                    $op = null;
                    if(array_key_exists($id, $posts)) {
                    $post = $posts[$id];
                    $time = $post->created_at;
                    $op = $post->user;
                    }
                    $timeDisplay = $time->diffAsCarbonInterval(Carbon\Carbon::now());
                    $formatAs = null;
                    if($timeDisplay->s != 0) $formatAs = "s";
                    if($timeDisplay->h != 0) $formatAs = "h";
                    if($timeDisplay->d != 0) $formatAs = "d";
                    if($timeDisplay->m != 0) $formatAs = "m";
                    if($timeDisplay->y != 0) $formatAs = "y";
                    @endphp
                    <p> Latest post by &nbsp; <i class="far fa-user"></i> {{App\User::find($t->op)->name}}
                        {{$timeDisplay->format("%" . $formatAs)}}{{$formatAs}} ago</p>
                </div>
                    </div>
                    <div id="threads" class="col-sm-1">
                        <h1 class="title"> Replies </h1>
                        <p class="counter"> 34 </p>
                    </div>
                    <div id="score" class="col-sm-1">
                        <h1 class="title"> Viewed </h1>
                        <p class="counter"> 234 Times </p>
                    </div>
                    <hr />
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @auth
        <a href="post">
            <div id="postThread">
                <i class="fas fa-plus"></i>
                <h1> Create Thread </h1>
            </div>
        </a>
        @endauth
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
<meta name="color" content="{{$color}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/category.js')}}"> </script>
@stop