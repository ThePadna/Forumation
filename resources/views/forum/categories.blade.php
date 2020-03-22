@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<div id="wrapper">
    <div id="categories">
    @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
        <div class="row">
                @else
                <div class="row">
                <div id="title" class="col-7">
                    <p class="row-indicator"> Category</p>
                </div>
                <div id="recentlyUpdated" class="col-2">
                    <p class="row-indicator"> Recently Updated </p>
                </div>
                <div id="threads" class="col-1">
                    <p class="row-indicator"> Threads </p>
                </div>
                @foreach($categories as $c)
                <a href="/forum/category/{{str_replace(' ', '-', $c->name)}}/1" id="title" class="drop-zone col-7"
                    ondragover="event.preventDefault()"  categoryId='{{$c->id}}'>
                    <div class="catTitleWrapper">
                    @auth
                    @if(Auth::user()->role == "admin")
                        <div class="edit-btn">
                            <i id="edit" class="edit-category far fa-edit" categoryId='{{$c->id}}' categoryName='{{$c->name}}' categoryDesc='{{$c->desc}}'></i>
                            <i id="del" class="del-category fas fa-trash" categoryId='{{$c->id}}' categoryName='{{$c->name}}' categoryDesc='{{$c->desc}}'></i>
                        </div>
                    @endif
                    @endauth
                        <div class="catTitle">
                            <p id="name"> {{$c->name}} </p>
                        </div>
                    @auth
                    @if(Auth::user()->role == "admin")
                        <div class="switch-btn">
                            <i id="up" class="up-arrow fas fa-arrow-up" categoryId='{{$c->id}}' categoryName='{{$c->name}}'></i>
                            <i id="down" class="down-arrow fas fa-arrow-down" categoryId='{{$c->id}}' categoryName='{{$c->name}}'></i>
                        </div>
                    @endif
                    @endauth
                    </div>
                    <p id="desc"> {{$c->desc}} </p>
                    <hr />
                </a>
                @php
                $threads = App\Models\Thread::where('categoryId', $c->id)->get();
                $recentThread = $threads->last();
                $threadCount = sizeof($threads);
                @endphp
                <div class="col-2 recentlyUpdated">
                @if($recentThread == null)
                <p class="recentTitle">  No threads for this category.</p>
                    <p class="recentPoster"> Bot, just now </p>
                    @else
                    @php
                    $time = \Carbon\Carbon::createFromTimeStamp(strtotime($recentThread->created_at));
                    $timeDisplay = $time->diff(\Carbon\Carbon::now());
                    $formatAs = null;
                    if($timeDisplay->s != 0) $formatAs = "s";
                    if($timeDisplay->i != 0) $formatAs = "i";
                    if($timeDisplay->h != 0) $formatAs = "h";
                    if($timeDisplay->d != 0) $formatAs = "d";
                    $suffix = $formatAs;
                    if($formatAs == "i") $suffix = "m";
                    @endphp
                    <p class="recentTitle">  {{$recentThread->title}}</p>
                    <p class="recentPoster"> {{App\User::find($recentThread->op)->name}}, {{$timeDisplay->format('%' . $formatAs)}}{{$suffix}} ago </p>
                    @endif
                </div>
                <div class="col-1 threads">
                    <p class="thread-count"> {{$threadCount}} </p>
                </div>
                @endforeach
                @endif
        </div>
        @auth
        @if(Auth::user()->role == "admin")
        <div id="categoryFormOpener">
            <i class="fas fa-plus"></i>
            <h1> Post new Category </h1>
        </div>
        @endif
        @endauth
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="color" content="{{$color}}">
<meta name="editor-mode" content="{{$editormode}}">
<script src="{{asset('js/categories.js')}}"> </script>
@stop