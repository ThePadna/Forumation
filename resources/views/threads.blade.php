@extends('layouts/forum_layout')
@section('content')
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<div id="wrapper">
<div id="threads">
@foreach($category as $c)
<a href="/threads/{{$t->id}}">
<div id="thread">
<div id="title">
<p> {{$t->title}}</p>
</div>
<div id="op">
<p> Submitted by &nbsp;<span> <span class="glyphicon glyphicon-user"> </span> {{$t->op}} &nbsp;  <span class="glyphicon glyphicon-fire">&nbsp;{{floor($t->posts)}}<span class="glyphicon glyphicon-envelope"> </span> </span></i></p>
</div>
</div>
</a>
@endforeach
</div>
<a href="/forum/{{$page < 2 ? 1 : $page - 1}}">
<div id="prevpage">
  <span class="glyphicon glyphicon-chevron-left" />
</div>
</a>
<a href="/forum/{{$page + 1}}">
<div id="nextpage">
  <span class="glyphicon glyphicon-chevron-right" />
</div>
</a>
</div>
<style>
#prevpage,#nextpage {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
  position: fixed;
  opacity: 0.8;
  color: #0a0f0f;
  font-size: 100px;
}
#prevpage {
  left: 50px;
  font-size: 100px;
}
#nextpage {
  right: 50px;
  font-size: 100px;
}
span {
  font-style: italic;
}
body {
  background-color: white;
}
a {
  text-decoration: none;
}
#wrapper {
  text-align: center;
  display: flex;
  justify-content: center;
}
#op>p {
  font-size: 15px;
}
#title>p {
  border-radius: 25px;
  font-size: 30px;
  color: black;
  font-weight: bold;
}
#thread {
  margin-bottom: 15px;
}
#threads {
}
</style>
@stop