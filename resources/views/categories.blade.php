<html>
@extends('layouts/forum_layout')
@section('content')
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<div id="wrapper">
<div id="categories">
@if(sizeof($categories) < 1)
<h1> No Categories found. </h1>
@else
@foreach($categories as $c)
<a href="/category/{{$c->id}}">
<div id="category">
<div id="name">
<p> {{$c->name}}</p>
</div>
</div>
</a>
@endforeach
@endif
@stop
</html>