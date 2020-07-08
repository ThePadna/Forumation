@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/category.css')}}">
@php
$settings = App\Models\Settings::first();
$default = $settings->default_rank;
$rank = App\Models\Rank::find($default);
if(Auth::check()) {
    $rank = Auth::user()->getRank();
}
@endphp
@if(file_exists(public_path() . '/img/category_bg.png'))
<body style="background: url('{{asset('img/category_bg.png')}}')">
@endif
@if(file_exists(public_path() . '/img/category_bg.jpg'))
<body style="background: url('{{asset('img/category_bg.jpg')}}')">
@endif
@if(file_exists(public_path() . '/img/category_bg.webp'))
<body style="background: url('{{asset('img/category_bg.webp')}}')">
@endif
<div id="wrapper">
@if($lastPage != 1)
    @php
    $displayNumbers = array();
    for($x = $page - 2; $x <= $page + 2; $x++) {
        if($x > $lastPage || $x <= 0) continue;
        $displayNumbers[$x] = $x;
    }
    @endphp
    <!-- Page selector -->
    <div class="page-selector">
    <p class="page-info"> Page {{$page}} of {{$lastPage}} </p>
    <div class="selectors">
    @if($lastPage > 3)
    <a href="{{$thread->getURI(1)}}">
    <div class="selector-wrapper">
        <h1 class="selector"> < </h1>
    </div>
    </a>
    @endif
    @if($lastPage != 1)
    @foreach($displayNumbers as $num)
        @if($page == $num)
        <div class="selector-wrapper" style="border: 1px solid #007bff;">
        @else
        <a href="{{$thread->getURI($num)}}"> 
        <div class="selector-wrapper">
        @endif
            <h1 class="selector"> {{$num}} </h1>
        </div>
        </a>
    @endforeach
    @endif
    @if($lastPage > 3)
    <a href="{{$thread->getURI($lastPage)}}">
    <div class="selector-wrapper">
        <h1 class="selector"> > </h1>
    </div>
    </a>
    @endif
    </div>
    </div>
    @else
    <p class="page-info"> Page {{$page}} of {{$lastPage}} </p>
    @endif
    <!-- Page selector -->
    @auth
    @if($rank->hasPerm("threadcreate"))
    <div id="add-thread">
        <img id="add-thread-avatar" src="{{Auth::user()->getAvatar()}}" />
        <input id="post-thread-input" placeholder="Post New Thread" />
    </div>
    @endif
    @endauth
    @if(sizeof($threads) == 0)
    <div id="no-threads">
        <i class="fas fa-frown"></i>
        <h1> No threads have been posted yet in this Category. </h1>
    </div>
    @else
    <div id="threads">
        @foreach($threads as $t)
            <div class="thread" onclick="window.location='{{$t->getURI(1)}}'" style="cursor: pointer;" tabindex="1">
                <div class="row">
                    <div class="col-8">
                        <div class="posts-content">
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
                            @php
                            $user = App\User::find($t->op);
                            @endphp
                            <p>
                                Latest post by &nbsp;
                                <a href="{{$user->getURI(1)}}"> 
                                <img class="latest-post-img" src="{{base64_decode($user->getAvatar())}}" />
                                {{$user->name}}
                                </a>
                                {{$timeDisplay->format('%' . $formatAs) . $suffix}} ago 
                            </p>
                            @else
                            <p> This thread has no posts yet </p>
                            @endif
                        </div>
                        </div>
                    </div>
                    <div id="threads" class="col-1">
                        <div class="threads-content">
                        <h1 class="title"> Posts </h1>
                        <p class="counter" style="color: #C5C3C3;"> {{$replies}} </p>
                        </div>
                    </div>
                    <div id="score" class="col-2">
                        <div class="score-content">
                        <h1 class="title"> Viewed </h1>
                        <p class="counter" style="color: #C5C3C3;"> {{$viewed}} Times </p>
                        @if($rank->hasPerm("threaddelete"))
                        <div class="edit-btn" onclick="event.stopPropagation();">
                            <i class="del-thread fas fa-trash" threadId='{{$t->id}}'
                                threadName='{{$t->title}}'></i>
                        </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
    @if($lastPage != 1)
    <!-- Page selector -->
    <div class="page-selector">
    <p class="page-info"> Page {{$page}} of {{$lastPage}} </p>
    <div class="selectors">
    @if($lastPage > 3)
    <a href="{{$thread->getURI(1)}}">
    <div class="selector-wrapper">
        <h1 class="selector"> < </h1>
    </div>
    </a>
    @endif
    @if($lastPage != 1)
    @foreach($displayNumbers as $num)
        @if($page == $num)
        <div class="selector-wrapper" style="border: 1px solid #007bff;">
        @else
        <a href="{{$thread->getURI($num)}}"> 
        <div class="selector-wrapper">
        @endif
            <h1 class="selector"> {{$num}} </h1>
        </div>
        </a>
    @endforeach
    @endif
    @if($lastPage > 3)
    <a href="{{$thread->getURI($lastPage)}}">
    <div class="selector-wrapper">
        <h1 class="selector"> > </h1>
    </div>
    </a>
    @endif
    </div>
    </div>
    @else
    <p class="page-info"> Page {{$page}} of {{$lastPage}} </p>
    @endif
    <!-- Page selector -->
</div>
<meta name="color" content="{{$settings->color}}">
<meta name="category" content="{{$category->name}}">
<meta name="csrf" content="{{csrf_token()}}">
<meta name="editor-mode" content="{{$settings->editormode}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/category.js')}}"> </script>
@stop