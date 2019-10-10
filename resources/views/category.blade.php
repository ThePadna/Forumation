@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/category.css')}}">
<div id="wrapper">
    <div id="threads">
        @foreach($threads as $t)
        <a href="/threads/{{$t->id}}">
            <div id="thread">
                <div id="title">
                    <p> {{$t->title}}</p>
                </div>
                <div id="op">
                    <p> Submitted by &nbsp;<span> <span class="glyphicon glyphicon-user"> </span> {{$t->op}} &nbsp;
                            <span class="glyphicon glyphicon-fire">&nbsp;{{floor($t->posts)}}<span
                                    class="glyphicon glyphicon-envelope"> </span> </span></i></p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <a href="/{{$category->name}}/{{$page < 2 ? 1 : $page - 1}}">
        <div id="prevpage">
        <i class="fas fa-long-arrow-alt-left"></i>
        </div>
    </a>
    <a href="/{{$category->name}}/{{$page + 1}}">
        <div id="nextpage">
        <i class="fas fa-long-arrow-alt-right"></i>
        </div>
    </a>
</div>
@stop