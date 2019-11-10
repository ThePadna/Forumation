@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/thread.css')}}">
<div id="wrapper">
    @foreach($posts as $p)
    <div id="container">
        <div class="row">
            <div id="test" class="col-sm-2">
                <img src="{{asset('img/profilepic.png')}}">
                <p> {{App\User::find($p->user)->name}} </p>
            </div>
            <div class="col-sm-10">
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