@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<div id="wrapper">
    <div id="categories">
        <div class="row">
            @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
                @else
                <div id="title" class="col-sm-8">
                    <p class="row-indicator"> Category</p>
                </div>
                <div id="recentlyUpdated" class="col-sm-2">
                    <p class="row-indicator"> Recently Updated </p>
                </div>
                <div id="threads" class="col-sm-1">
                    <p class="row-indicator"> Threads </p>
                </div>
                @foreach($categories as $c)
                <div id="title" class="drop-zone col-sm-8" ondragover="event.preventDefault()" draggable="true">
                    <p class="catTitle" categoryId="{{$c->id}}"> {{$c->name}}</p>
                    <br />
                    <p class="description"> Example description</p>
                    @auth
                    @if(Auth::user()->role == "admin")
                    <i class="edit-category far fa-edit"></i>
                    <i class="del-category fas fa-trash"></i>
                    @endif
                    @endauth
                </div>
                <div id="recentlyUpdated" class="col-sm-2">
                    <p class="recentTitle"> Why is my dog.. </p>
                    <p class="recentPoster"> Ixinon, 35m ago </p>
                </div>
                <div id="threads" class="col-sm-1">
                    <p> 305 </p>
                </div>
                @endforeach
                @endif
        </div>
        @auth
        @if(Auth::user()->role == "admin")
        <div id="categoryFormOpener">
            <i class="fas fa-plus"></i>
            <h1> Post new thread </h1>
        </div>
        @endif
        @endauth
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<script src="{{asset('js/categories.js')}}"> </script>
@stop