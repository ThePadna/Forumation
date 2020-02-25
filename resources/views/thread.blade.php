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
        <i id="edit" class="edit-category far fa-edit" threadId='{{$thread->id}}'></i>
        <i id="del" class="del-category fas fa-trash" threadId='{{$thread->id}}'></i>
        <i class="fas fa-lock" threadId='{{$thread->id}}'></i>
    </div>
    @endif
    @endauth
    <div id="titleContainer">
        <p id="threadTitle"> {{$thread->title}} </p>
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
                @if(!$isLikedByUser)
                <i class="far fa-star star-symbol" post="{{$p->id}}"></i>
                @else
                <i class="fas fa-star star-symbol" post="{{$p->id}}"></i>
                @endif
                <p class="star-count">{{$likeCount}}</p>
            </div>
            <a href="/forum/profile/{{$user->id}}" style="text-decoration: none; color: inherit;">
                <div id="test" class="col-sm-2">
                    <img src="{{base64_decode($user->avatar)}}">
                    <p> {{$user->name}} </p>
                    <div id="stats">
                        <p> {{$user->points}} <i style="color: {{$color}}" class="fas fa-star"></i>
                            {{App\Models\Post::where('user', $user->id)->get()->count()}} <i style="color: {{$color}}"
                                class="fas fa-comments"></i></p>
                    </div>
                </div>
            </a>
            <div class="col-sm-1 splitter">
                <hr />
            </div>
            <div class="col-sm-7">
                {{$p->contents}}
            </div>
            <div class="post-edit">
                <i class="fas fa-eraser erase"></i>
            </div>
        </div>
        <hr />
    </div>
    @endforeach
    @if($empty)
    <p id="empty"> There are no new posts at this time on this topic. :( </p>
    @endif
    @auth
    @if($isLastPage || $empty)
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
<meta name="color" content="{{$color}}">
<script src="{{asset('js/thread.js')}}"> </script>
@stop