@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/post.css')}}">
<div id="wrapper">
    <div id="post">
        <form>
            <input id="threadTitle" name="threadTitle" type="text" placeholder="The title of your post" /> <br />
            <textarea id="threadText" name="threadText" cols="50" rows="10"></textarea> <br />
            <button id="postThread"> POST </button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<script src="{{asset('js/post.js')}}"> </script>
@stop