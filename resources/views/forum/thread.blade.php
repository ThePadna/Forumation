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
    <div id="titleContainer">
        <p id="threadTitle"> {{$thread->title}} </p>
        @if($thread->locked)
        <p style="color:red; font-size: 2vh;"> <i class="fas fa-lock"></i> This thread has been locked. </h1>
            @endif
            <hr />
    </div>
    @foreach($posts as $p)
    @php
    $user = App\User::find($p->user);
    @endphp
    <div id="container">
        <div class="row">
            <div id="star" class="col-sm-1">
                @php
                $users_liked = unserialize($p->liked_by);
                $likeCount = 0;
                $isLikedByUser = false;
                if($users_liked != null) {
                $isLikedByUser = in_array(Auth::user()->id, $users_liked);
                $likeCount = sizeof($users_liked);
                }
                @endphp
                @if(!$p->erased)
                @if(!$isLikedByUser)
                <i class="far fa-star star-symbol" post="{{$p->id}}"></i>
                @else
                <i class="fas fa-star star-symbol" post="{{$p->id}}"></i>
                @endif
                <p class="star-count">{{$likeCount}}</p>
                @endif
            </div>
            @if($p->erased)
            <a style="text-decoration: none; color: inherit;">
                @else
                <a href="/forum/profile/{{$user->name}}" style="text-decoration: none; color: inherit;">
                    @endif
                    <div id="test" class="col-sm-2">
                        @if($p->erased)
                        <img id="profilepic" src="{{asset('img/profilepic.png')}}">
                        <p> Removed </p>
                        <div id="stats">
                            <p> 0 <i style="color: {{$color}}" class="fas fa-star"></i>
                                0 <i style="color: {{$color}}" class="fas fa-comments"></i></p>
                        </div>
                        @else
                        @if($user->avatar == null)
                        <img id="profilepic" src="{{asset('img/profilepic.png')}}" />
                        @else
                        <img id="profilepic" src="{{base64_decode($user->avatar)}}" />
                        @endif
                        <p> {{$user->name}} </p>
                        <div id="stats">
                            <p> {{$user->score}} <i style="color: {{$color}}" class="fas fa-star"></i>
                                {{App\Models\Post::where('user', $user->id)->get()->count()}} <i
                                    style="color: {{$color}}" class="fas fa-comments"></i></p>
                        </div>
                        @endif
                    </div>
                </a>
                <div class="col-sm-1 splitter">
                    <hr />
                </div>
                <div class="col-sm-7">
                    @if($p->erased)
                    <p style="color:red">This post has been erased.</p>
                    @else
                    {{$p->contents}}
                    @endif
                </div>
                <div class="post-edit">
                    <i class="fas fa-eraser erase" post="{{$p->id}}"></i>
                </div>
        </div>
        <hr />
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