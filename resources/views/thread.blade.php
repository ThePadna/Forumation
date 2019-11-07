@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/thread.css')}}">
<div id="wrapper">
    @foreach($posts as $p)
    <div id="container">
        <div class="row">
            <div id="test" class="col-sm-2">
                <p> {{App\User::find($p->user)->name}} </p>
            </div>
            <div class="col-sm-10">
                {{$p->contents}}
            </div>
        </div>
    </div>
    @endforeach
    @auth
    @if($isLastPage)
    <div id="replyForm">
        <form>
            <textarea id="replyText" name="replyText" placeholder="What are your thoughts?"></textarea>
            <button id="postReply"> POST </button>
        </form>
    </div>
    @endif
    @endauth
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<script src="{{asset('js/thread.js')}}"> </script>
@stop