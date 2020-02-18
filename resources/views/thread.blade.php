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
            <a href="/forum/profile/{{$user->id}}" style="text-decoration: none; color: inherit;">
            <div id="test" class="col-sm-2">
                <img src="{{base64_decode($user->avatar)}}">
                <p> {{$user->name}} </p>
                <div id="stats">
                    <p> {{$user->points}} <i style="color: {{$color}}" class="fas fa-star"></i>  {{App\Models\Post::where('user', $user->id)->count()}} <i style="color: {{$color}}" class="fas fa-comments"></i></p>
                </div>
            </div>
            </a>
            <div class="col-sm-1">
                <hr />
            </div>
            <div class="col-sm-8">
                {{$p->contents}}
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