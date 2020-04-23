@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/category.css')}}">
@php
$create = false;
$delete = false;
$rank = null;
if(Auth::check()) {
$rank = Auth::user()->rank;
if($rank == null) {
$settings = App\Models\Settings::first();
if($settings != null) {
$default = $settings->default_rank;
$rank = App\Models\Rank::find($default);
}
if($rank != null) {
$perms = unserialize($rank->permissions);
if(in_array('threadcreate', $perms)) $create = true;
if(in_array('threaddelete', $perms)) $delete = true;
}
}
}
@endphp
<div id="wrapper">
    <div id="threads">
        @foreach($threads as $t)
        <a href="thread/{{str_replace(' ', '-', substr($t->title, 0, 20))}}-{{$t->id}}/1">
            <div class="thread">
                <div class="row">
                    <div id="posts" class="col-sm-8">
                        @if($t->locked)
                        <h1 class="title"> <i class="fas fa-lock"></i> {{$t->title}} </h1>
                        @else
                        <h1 class="title" style="font-weight: 550;"> {{$t->title}} </h1>
                        @endif
                        <div class="op">
                            @php
                            $id = $t->id;
                            $time = null;
                            $op = null;
                            $posts = App\Models\Post::where('thread', $id)->get();
                            $viewed = 0;
                            $users = unserialize($t->viewed_by);
                            if($users != null) $viewed = sizeof($users);
                            $replies = sizeof($posts);
                            if(sizeof($posts) != 0) {
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
                            }
                            @endphp
                            @if(sizeof($posts) != 0)
                            <h5>
                            <span style="color:{{$color}}; font-style: normal;"> Latest post by </span> &nbsp; <i
                                class="far fa-user"></i>
                            <a href="/forum/profile/{{App\User::find($t->op)->name}}">
                                <span style="color:black;">{{App\User::find($t->op)->name}}</span> </a>
                            <span style="color:{{$color}}; font-style: normal;"> {{$timeDisplay->format('%' . $formatAs) . $suffix}} ago </span>
                            </h5>
                            @else
                            <p> This thread has no posts yet </p>
                            @endif
                        </div>
                    </div>
                    <div id="threads" class="col-sm-1">
                        <h1 class="title"> Posts </h1>
                        <p class="counter"> {{$replies}} </p>
                    </div>
                    <div id="score" class="col-sm-1">
                        <h1 class="title"> Viewed </h1>
                        <p class="counter"> {{$viewed}} Times </p>
                        @if($delete)
                        <div class="edit-btn">
                            <i id="del" class="del-thread fas fa-trash" threadId='{{$t->id}}'
                                threadName='{{$t->title}}'></i>
                        </div>
                        @endif
                    </div>
                    <hr />
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @if($create)
    <a href="post">
        <div id="postThread">
            <i class="fas fa-plus"></i>
            <h1> Create Thread </h1>
        </div>
    </a>
    @endif
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
<meta name="csrf" content="{{csrf_token()}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/category.js')}}"> </script>
@stop