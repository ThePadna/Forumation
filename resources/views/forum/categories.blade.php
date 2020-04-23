@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
@php
$rank = null;
$switch = false;
$add = false;
$delete = false;
$edit = false;
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
if(in_array('categoryswitch', $perms)) $switch = true;
if(in_array('categoryadd', $perms)) $add = true;
if(in_array('categorydelete', $perms)) $delete = true;
if(in_array('categoryedit', $perms)) $edit = true;
}
}
}
@endphp
<div class="wrapper">
    @if(sizeof($categories) < 1) <h1 style="text-align: center;"> No Categories found. </h1>
        @else
        <div id="table-header" class="row">
            <h1 class="col-5"> Category </h1>
            <h1 class="col-2"> Latest </h1>
            <h1 id="threads" class="col-1"> Threads </h1>
        </div>
        <br />
        <br />
        @foreach($categories as $c)
        <div class="row">
            <div id="title" class="col-5">
                <div class="editor-btn">
                @if($switch)
                    <div class="switch-btn">
                        <i id="up" class="up-arrow fas fa-arrow-up" categoryId='{{$c->id}}'
                            categoryName='{{$c->name}}'></i>
                        <i id="down" class="down-arrow fas fa-arrow-down" categoryId='{{$c->id}}'
                            categoryName='{{$c->name}}'></i>
                    </div>
                    @endif
                    <div class="edit-btn">
                    @if($edit)
                        <i id="edit" class="edit-category far fa-edit" categoryId='{{$c->id}}'
                            categoryName='{{$c->name}}' categoryDesc='{{$c->desc}}'></i>
                            @endif
                            @if($delete)
                        <i id="del" class="del-category fas fa-trash" categoryId='{{$c->id}}'
                            categoryName='{{$c->name}}' categoryDesc='{{$c->desc}}'></i>
                            @endif
                    </div>
                </div>
                <a href="/forum/category/{{str_replace(' ', '-', $c->name)}}/1" class="data-title"
                    ondragover="event.preventDefault()" categoryId='{{$c->id}}'>
                    <h1 class="title"> {{$c->name}} </h1>
                    <h1 class="desc"> {{$c->desc}} </h1>
                </a>
            </div>
            @php
            $threads = App\Models\Thread::where('categoryId', $c->id)->get();
            $recentThread = $threads->last();
            $threadCount = sizeof($threads);
            @endphp
            <div class="col-2">
                @if($recentThread == null)
                <p class="recentTitle"> No threads for this category.</p>
                <p class="recentPoster"> <i class="far fa-user"></i> Bot, just now </p>
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
                $name = App\User::find($recentThread->op)->name;
                $title = strlen($recentThread->title) >= 30 ? substr($recentThread->title, 0, 30) . '..' :
                $recentThread->title;
                @endphp
                <p class="recentTitle">{{$title}}</p>
                <p class="recentPoster" style="white-space: no-wrap; overflow: hidden;"> <a
                        href="forum/profile/{{$name}}" style=" color:{{$color}}"> by <span
                            style="color:black; font-style: italic;"><i class="far fa-user"></i> {{$name}} </span></a>,
                    {{$timeDisplay->format('%' . $formatAs)}}{{$suffix}} ago </p>
                @endif
            </div>
            <div id="threads" class="col-1">
                <div class="col-1">
                    <p class="thread-count"> {{$threadCount}}</p>
                </div>
            </div>
            <hr />
        </div>
        @endforeach
</div>
@endif
@if($add)
<div id="addCategory">
    <i class="fas fa-plus"></i>
    <h1> Add Category </h1>
</div>
@endif
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="color" content="{{$color}}">
<meta name="editor-mode" content="{{$editormode}}">
<script src="{{asset('js/categories.js')}}"> </script>
@stop