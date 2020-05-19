@extends('layouts/forum_layout')
@section('content')
@auth
@php
$viewed_by = $thread->viewed_by;
$users = unserialize($viewed_by);
$id = Auth::user()->id;
if($users == null) {
$users = Array($id);
$thread->viewed_by = serialize($users);
$thread->save();
} else {
if(!in_array($id, $users)) array_push($users, $id);
$thread->viewed_by = serialize($users);
$thread->save();
}
@endphp
@endauth
@php
$star = false;
$erase = false;
$eraseSelf = false;
$create = false;
$rank = null;
if(Auth::check()) {
$rank = Auth::user()->rank;
$rank = App\Models\Rank::find($rank);
if($rank == null) {
$settings = App\Models\Settings::first();
if($settings != null) {
$default = $settings->default_rank;
$rank = App\Models\Rank::find($default);
}
}
if($rank != null) {
$perms = unserialize($rank->permissions);
if(in_array('poststar', $perms)) $star = true;
if(in_array('postcreate', $perms)) $create = true;
if(in_array('posteraseself', $perms)) $eraseSelf = true;
if(in_array('posterase', $perms)) $erase = true;
}
}
$category = App\Models\Category::find($thread->categoryId);
$op = App\User::find($thread->op);
@endphp
<link rel="stylesheet" href="{{asset('css/thread.css')}}">
<div id="wrapper">
    @auth
    @if(Auth::user()->role == "admin")
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
        <a href="/forum/category/{{$category->name}}/thread/{{str_replace(' ', '-', substr($thread->title, 0, 20))}}-{{$thread->id}}/1">
            <div class="thread-title-wrapper">
            <p id="thread-title"> {{$thread->title}} </p>
            </div>
        </a>
    <div class="thread-detail-wrapper">
        <p class="thread-detail"> Thread in <a href="/forum/category/{{$category->name}}/1"> {{$category->name}}
            </a> by
            <a href="/forum/profile/{{$op->name}}"> {{$op->name}} </a> </p>
    </div>
    @if($thread->locked)
    <div class="thread-title-wrapper">
        <p style="color:red; font-size: 2vh;"> <i class="fas fa-lock"></i> This thread has been locked. </h1>
    </div>
    @endif
</div>
@php
$i = 0;
@endphp
@foreach($posts as $p)
@php
$i++;
$user = App\User::find($p->user);
@endphp
<div id="container">
    <div class="row">
        <div class="col-1">
            <div class="star">
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
                @if($star)
                <i class="far fa-star star-symbol" post="{{$p->id}}"></i>
                @else
                <i class="far fa-star star-symbol-disabled" post="{{$p->id}}"></i>
                @endif
                @else
                @if($star)
                <i class="fas fa-star star-symbol" post="{{$p->id}}"></i>
                @else
                <i class="fas fa-star star-symbol-disabled" post="{{$p->id}}"></i>
                @endif
                @endif
                <p class="star-count">{{$likeCount}}</p>
                @endif
            </div>
        </div>
        @if($p->erased)
        <a style="text-decoration: none; color: inherit;">
            @else
            <a href="/forum/profile/{{$user->name}}" style="text-decoration: none; color: inherit;">
                @endif
                <div class="col-4">
                    @if($p->erased)
                    <img id="profilepic" src="{{asset('default_avatar.png')}}">
                    <p> Removed </p>
                    <div id="stats">
                        <p> 0 <i style="color: {{$color}}" class="fas fa-star"></i>
                            0 <i style="color: {{$color}}" class="fas fa-comments"></i></p>
                    </div>
                    @else
                    @if($user->avatar == null)
                    <img class="avatar" src="{{asset('default_avatar.png')}}" />
                    @else
                    <img class="avatar" src="{{base64_decode($user->avatar)}}" />
                    @endif
                    <div class="stats">
                        @php
                        $posts1 = App\Models\Post::where('user', $user->id)->get();
                        $score = 0;
                        foreach($posts1 as $p1) {
                        if($p1->liked_by != '') {
                        $score += sizeof(unserialize($p1->liked_by));
                        }
                        }
                        $comments = sizeof($posts1);
                        @endphp
                        <p> {{$score}} <i style="color: {{$color}}" class="fas fa-star"></i>
                            {{$comments}} <i style="color: {{$color}}" class="fas fa-comments"></i></p>
                    </div>
                    <div class="username-wrapper">
                        <p class="username"> {{$user->name}} </p>
                    </div>
                    @php
                    $rankId = $user->rank;
                    $rank = App\Models\Rank::find($rankId);
                    $rankName = "";
                    $rankColor = "#00000";
                    if($rank != null) {
                    $rankName = $rank->name;
                    $rankColor = $rank->color;
                    } else {
                    $default = $settings->default_rank;
                    $rank = App\Models\Rank::find($default);
                    if($rank != null) {
                    $rankName = $rank->name;
                    $rankColor = $rank->color;
                    }
                    }
                    @endphp
                    <div class="rank-container">
                        <p class="rank" style="color:{{$rankColor}};"> {{$rankName}} </p>
                    </div>
                    @endif
                </div>
            </a>
            <div class="col-6">
                <div class="post-wrapper">
                    @if($p->erased)
                    <p style="color:red">This post has been erased.</p>
                    @else
                    <div class="post-content-wrapper">
                        <p class="post-content">
                            {{$p->contents}}
                        </p>
                    </div>
                    <div class="post-footer-wrapper">
                        <p class="post-footer"> Posted on {{$p->created_at}} </p>
                    </div>
                    @endif
                </div>
            </div>
    </div>
</div>
@endforeach
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
@if($page > 1)
<a href="{{$page < 2 ? 1 : $page - 1}}">
    <div id="prevpage">
        <i class="fas fa-long-arrow-alt-left"></i>
    </div>
</a>
@endif
@if(!$isLastPage)
<a href="{{$page + 1}}">
    <div id="nextpage">
        <i class="fas fa-long-arrow-alt-right"></i>
    </div>
</a>
<a href="{{$lastPage}}">
    <div id="lastpage">
        <i class="fas fa-fast-forward"></i>
    </div>
</a>
@endif
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="thread" content="{{$thread->id}}">
<meta name="category" content="{{$thread->categoryId}}">
<meta name="color" content="{{$color}}">
<meta name="thread-length" content="{{$threadLength}}">
<script src="{{asset('js/thread.js')}}"> </script>
@stop