@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/category.css')}}">
<div id="wrapper">
    <div id="threads">
    {{sizeof($threads)}}
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
                    $posts = App\Models\Post::where('thread', $id)->get();
                    $latestPost = $posts[sizeof($posts) - 1];
                    $time = \Carbon\Carbon::createFromTimeStamp(strtotime($latestPost->created_at));
                    $op = $posts[0]->user;
                    $timeDisplay = $time->diff(\Carbon\Carbon::now());
                    $formatAs = null;
                    if($timeDisplay->s != 0) $formatAs = "s";
                    if($timeDisplay->i != 0) $formatAs = "i";
                    if($timeDisplay->h != 0) $formatAs = "h";
                    if($timeDisplay->d != 0) $formatAs = "d";
                    $suffix = $formatAs;
                    if($formatAs == "i") $suffix = "m";
                    $viewed = 0;
                    $users = unserialize($t->viewed_by);
                    if($users != null) $viewed = sizeof($users);
                    $replies = sizeof($posts);
                    @endphp
                    <p> Latest post by &nbsp; <i class="far fa-user"></i> <a href="/forum/profile/{{$t->op}}"><span style="color:black;">{{App\User::find($t->op)->name}}</span> </a>
                        {{$timeDisplay->format('%' . $formatAs) . $suffix}} ago</p>
                </div>
                    </div>
                    <div id="threads" class="col-sm-1">
                        <h1 class="title"> Posts </h1>
                        <p class="counter"> {{$replies}} </p>
                    </div>
                    <div id="score" class="col-sm-1">
                        <h1 class="title"> Viewed </h1>
                        <p class="counter"> {{$viewed}} Times </p>
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
    @if(sizeof($threads) >= 9)
    <a href="{{$page + 1}}">
        <div id="nextpage">
            <i class="fas fa-long-arrow-alt-right"></i>
        </div>
    </a>
    @endif
</div>
<meta name="color" content="{{$color}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/category.js')}}"> </script>
@stop