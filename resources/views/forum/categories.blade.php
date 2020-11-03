@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
@php
$settings = App\Models\Settings::first();
$default = $settings->default_rank;
$rank = App\Models\Rank::find($default);
if(Auth::check()) {
$rank = Auth::user()->getRank();
}
@endphp
@if(file_exists(public_path() . '/img/categories_bg.png'))
<body style="background: url('{{asset('img/categories_bg.png')}}') fixed;">
@endif
@if(file_exists(public_path() . '/img/categories_bg.jpg'))
<body style="background: url('{{asset('img/categories_bg.jpg')}}') fixed;">
@endif
@if(file_exists(public_path() . '/img/categories_bg.webp'))
<body style="background: url('{{asset('img/categories_bg.webp')}}') fixed;">
@endif
<body>
<div id="wrapper">
    <div id="categories">
        @if(sizeof($categories) < 1) <h1 style="text-align: center; color: white; opacity: 0.6;"> No Categories found. </h1>
            @else
            <div id="table-header" class="row">
                <h1 class="col-5"> Category </h1>
                <h1 class="col-3"> Latest </h1>
                <h1 id="threads" class="col-1"> Threads </h1>
            </div>
                @foreach($categories as $c)
                <div class="category" onclick="window.location='{{asset('/category/' . str_replace(' ', '-', $c->name) . '/1')}}'" style="cursor: pointer;" tabindex="1">
                    <div class="row">
                        <!-- Title -->
                        <div id="title" class="col-5">
                            <div class="title-content">
                            <h1 class="title"> {{$c->name}} </h1>
                            <h1 class="desc"> {{$c->desc}} </h1>
                            <div class="editor-btn">
                            @if($rank != null && $rank->hasPerm("categoryswitch"))
                            <div class="switch-btn" onclick="event.stopPropagation();">
                                <i id="up" class="up-arrow fas fa-arrow-up" categoryId='{{$c->id}}'
                                    categoryName='{{$c->name}}'></i>
                                <i id="down" class="down-arrow fas fa-arrow-down" categoryId='{{$c->id}}'
                                    categoryName='{{$c->name}}'></i>
                            </div>
                            @endif
                            <div class="edit-btn" onclick="event.stopPropagation();">
                            @if($rank != null && $rank->hasPerm("categoryedit"))
                                <i id="edit" class="edit-category far fa-edit" categoryId='{{$c->id}}'
                                categoryName='{{$c->name}}' categoryDesc='{{$c->desc}}'></i>
                            @endif
                            @if($rank != null && $rank->hasPerm("categorydelete"))
                                <i id="del" class="del-category fas fa-trash" categoryId='{{$c->id}}'
                                categoryName='{{$c->name}}' categoryDesc='{{$c->desc}}'></i>
                            @endif
                            </div>
                            </div>
                            </div>
                        </div>
                        <!-- Title -->
                        @php
                            $threads = App\Models\Thread::where('categoryId', $c->id)->get();
                            $recentThread = $threads->last();
                            $threadCount = sizeof($threads);
                        @endphp
                        <div class="col-3">
                        <div class="recent-thread-content">
                @if($recentThread == null)
                <p class="recent-title"> No threads for this category.</p>
                <p class="recent-poster"> <i class="far fa-user"></i> Bot, just now </p>
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
                $op = $recentThread->getOP();
                $name = $op->name;
                $title = strlen($recentThread->title) >= 30 ? substr($recentThread->title, 0, 30) . '..' :
                $recentThread->title;
                @endphp
                <a href="{{$recentThread->getURI(1)}}"><p class="recent-title">{{$title}}</p></a>
                <p class="recent-poster"> <a
                        href="{{asset('/profile/' . $name)}}"> <img class="recent-poster-avatar" src="{{base64_decode($op->avatar)}}"> {{$name}} </span></a>,
                    {{$timeDisplay->format('%' . $formatAs)}}{{$suffix}} ago </p>
                @endif
            </div>
                        </div>
                        <!-- Recent Thread -->
                        <div id="threads" class="col-1">
                            <div class="thread-count-content">
                            <p class="thread-count"> {{$threadCount}}</p>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            @endif
            @if($rank != null && $rank->hasPerm("categoryadd"))
            <div id="add-category">
                <a>
                    <h1> Add New Category </h1>
                </a>
            </div>
            @endif
    </div>
</div>
</div>
</body>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="color" content="{{$color}}">
<meta name="editor-mode" content="{{$editormode}}">
<script src="{{asset('js/categories.js')}}"> </script>
@stop