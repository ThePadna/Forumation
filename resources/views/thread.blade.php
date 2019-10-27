@extends('layouts/forum_layout')
@section('content')
<div id="wrapper">
@foreach($posts as $p)
<div class="post">
<h1> {{$p->user}} </h1>
<p> {{$p->contents}}</p>
</div>
@endforeach
</div>
@stop