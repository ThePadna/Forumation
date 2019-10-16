@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/post.css')}}">
<div id="wrapper">
    <div id="post">
    <form>
        <input id="threadTitle" type="text" /> <br />
        <input id="threadText" type="text" /> <br />
        <button id="postThread"> POST </button>
    </form>
</div>
</div>
@stop