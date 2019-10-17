@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/post.css')}}">
<div id="wrapper">
    <div id="post">
    <form>
        <input id="threadTitle" type="text" placeholder="The title of your post" /> <br />
        <textarea id="threadText" cols="50" rows="10"></textarea> <br />
        <button id="postThread"> POST </button>
    </form>
</div>
</div>
@stop