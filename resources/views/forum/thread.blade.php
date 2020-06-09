@extends('layouts/forum_layout')
@section('content')
@php
$settings = App\Models\Settings::first();
$default = $settings->default_rank;
$rank = App\Models\Rank::find($default);
if(Auth::check()) {
    $rank = Auth::user()->getRank();
    $thread->markViewer(Auth::user());
}
$category = App\Models\Category::find($thread->categoryId);
$op = App\User::find($thread->op);
@endphp
<link rel="stylesheet" href="{{asset('css/thread.css')}}">
@if(file_exists(public_path() . '/img/categories_bg.png'))
<body style="background: url('{{asset('img/categories_bg.png')}}') fixed;">
@endif
@if(file_exists(public_path() . '/img/categories_bg.jpg'))
<body style="background: url('{{asset('img/categories_bg.jpg')}}') fixed;">
@endif
@if(file_exists(public_path() . '/img/categories_bg.webp'))
<body style="background: url('{{asset('img/categories_bg.webp')}}') no-repeat center center fixed;">
@endif
<body>
<div id="wrapper">
    @auth
    @if($rank->hasPerm("threadedit"))
    <div class="edit-btn">
        <!-- <i class="edit-category far fa-edit edit" threadId='{{$thread->id}}'></i> -->
        <i class="del-category fas fa-trash del" threadId='{{$thread->id}}'></i>
        <i class="fas fa-lock lock" threadId='{{$thread->id}}'></i>
    </div>
    @endif
    @endauth
    <div id="title-container">
        @php
        $category = App\Models\Category::find($thread->categoryId);
        @endphp
        <div class="thread-detail-wrapper">
            <p class="thread-detail"> Thread in 
                <a href="/forum/category/{{$category->name}}/1"> {{$category->name}}
                </a> by
                <a href="/forum/profile/{{$op->name}}"> {{$op->name}} </a> 
            </p>
         </div>
    @if($thread->locked)
    <div class="thread-title-wrapper">
        <p style="color:red; font-size: 2vh;"> <i class="fas fa-lock"></i> This thread has been locked. </h1>
    </div>
    @endif
</div>
<div id="container">
    @php
    $displayNumbers = array();
    for($x = $page - 2; $x <= $page + 2; $x++) {
        if($x > $lastPage || $x <= 0) continue;
        $displayNumbers[$x] = $x;
    }
    @endphp
    <!-- Page selector -->
    @if($page > 0)
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
    @if($lastPage > 3)
    <a href="{{$thread->getURI($lastPage)}}">
    <div class="selector-wrapper">
        <h1 class="selector"> > </h1>
    </div>
    </a>
    @endif
    </div>
    </div>
    @endif
    <!-- Page selector -->
    <!-- Start posts loop -->
    @php
    $i = 0;
    @endphp
    @foreach($posts as $p)
    @php
    $i++;
    $user = App\User::find($p->user);
    @endphp
    <div class="row">
    @php
    $avatar = base64_decode($user->getAvatar());
    $name = $user->name;
    $rank = $user->getRank();
    if($p->erased) {
        $avatar = asset('default_avatar.png');
        $name = "Removed";
        $rank = null;
    }
    @endphp
            <div class="reply-counter">
                <h1 class="reply-count"> #{{$i}} </h1>
            </div>  
            <div class="profile-box">
                <div class="avatar-container">
                    <img class="avatar" src="{{$avatar}}"> </img>
                </div>
                <div class="username-container">
                    <div class="username-wrapper">
                        <p class="username"> {{$name}} </p>
                    </div>
                </div>
                @if($rank != null)
                <div class="rank-container">
                    <div class="ribbon" style="background:{{$rank->color}}">
                        <div class="rank-wrapper">
                            <p class="rank" style="color:white"> {{$rank->name}} </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="post-bubble">
                <div class="post-content-wrapper post-content-right">
                    @if($i == 1)
                    <p class="post-title"> {{$thread->title}} </p>
                    <hr/>
                    @endif
                    <p class="post-content"> {{$p->contents}} </p>
                    <p class="post-footer"> Posted on {{$p->created_at}} </p>
                </div>
            </div>
            <div class="star star-right">
                @php
                $users_liked = unserialize($p->liked_by);
                $likeCount = 0;
                $isLikedByUser = false;
                if($users_liked != null && Auth::user() != null) {
                $isLikedByUser = in_array(Auth::user()->id, $users_liked);
                $likeCount = sizeof($users_liked);
                }
                @endphp
                @if(!$p->erased)
                @if(!$isLikedByUser)
                @if($rank->hasPerm("poststar"))
                <i class="far fa-star star-symbol" post="{{$p->id}}"></i>
                @else
                <i class="far fa-star star-symbol-disabled" post="{{$p->id}}"></i>
                @endif
                @else
                @if($rank->hasPerm("poststar"))
                <i class="fas fa-star star-symbol" post="{{$p->id}}"></i>
                @else
                <i class="fas fa-star star-symbol-disabled" post="{{$p->id}}"></i>
                @endif
                @endif
                <p class="star-count">{{$likeCount}}</p>
                @endif
            </div>
    </div>
    @endforeach
</div>
@if($empty)
<p id="empty"> There are no new posts at this time on this topic. :( </p>
@endif
@auth
@if($isLastPage && !$thread->locked)
<form id="replyForm">
    <textarea id="replyText" name="replyText" placeholder="What are your thoughts?"></textarea>
    <button id="postReply"> POST </button>
</form>
@endif
@endauth
 <!-- Page selector -->
 @if($page > 0)
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
    @if($lastPage > 3)
    <a href="{{$thread->getURI($lastPage)}}">
    <div class="selector-wrapper">
        <h1 class="selector"> > </h1>
    </div>
    </a>
    @endif
    </div>
    </div>
    @endif
    <!-- Page selector -->
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="thread" content="{{$thread->id}}">
<meta name="category" content="{{$thread->categoryId}}">
<meta name="color" content="{{$color}}">
<meta name="thread-length" content="{{$threadLength}}">
<script src="{{asset('js/thread.js')}}"> </script>
@stop