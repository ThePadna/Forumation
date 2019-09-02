@extends('forum_layout')
@section('content')
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<div id="wrapper">
<div id="categories">
@foreach($categories as $c)
<a href="/category/{{$c->id}}">
<div id="category">
<div id="name">
<p> {{$c->name}}</p>
</div>
</div>
</a>
@endforeach
@stop