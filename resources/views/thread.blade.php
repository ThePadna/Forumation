@extends('layouts/forum_layout')
@section('content')
<div id="wrapper">
@foreach($posts as $p)
<div class="post">
<h1> {{App\User::find($p->user)->name}} </h1>
<p> {{$p->contents}}</p>
</div>
@endforeach
</div>
@stop