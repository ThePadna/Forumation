@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/thread.css')}}">
<div id="wrapper">
@foreach($posts as $p)
<div class="post">
<h1> {{App\User::find($p->user)->name}} </h1>
<p> {{$p->contents}}</p>
</div>
@endforeach
</div>
@stop