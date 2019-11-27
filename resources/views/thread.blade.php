@extends('layouts/forum_layout')
@section('content')
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
            <div id="test" class="col-sm-2">
                <img src="{{base64_decode($user->avatar)}}">
                <p> {{$user->name}} </p>
                <div id="stats">
                    <p> 77  <i class="fas fa-star"></i></p>
                    <p> 21 <i class="fas fa-comments"></i> </p>
                </div>
            </div>
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
    @auth
    @if($isLastPage)
    <form id="replyForm">
        <textarea id="replyText" name="replyText" placeholder="What are your thoughts?"></textarea>
        <button id="postReply"> POST </button>
    </form>
    @endif
    @endauth
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="thread" content="{{$thread}}">
<script src="{{asset('js/thread.js')}}"> </script>
@stop