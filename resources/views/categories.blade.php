@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<div id="wrapper">
    <div id="categories">
        <div class="row">
            @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
                @else
                <div id="title" class="col-8">
                    <p class="row-indicator"> Category</p>
                </div>
                <div id="recentlyUpdated" class="col-2">
                    <p class="row-indicator"> Recently Updated </p>
                </div>
                <div id="threads" class="col-1">
                    <p class="row-indicator"> Threads </p>
                </div>
                @foreach($categories as $c)
                <a href="/forum/category/{{$c->id}}/1" id="title" categoryId="{{$c->id}}" class="drop-zone col-8"
                    ondragover="event.preventDefault()" draggable="true">
                    <div class="catTitleWrapper">
                    @auth
                    @if(Auth::user()->role == "admin")
                        <div class="edit-btn">
                            <i id="edit" class="edit-category far fa-edit"></i>
                            <i id="del" class="del-category fas fa-trash"></i>
                        </div>
                    @endif
                    @endauth
                        <div class="catTitle">
                            <p id="name"> {{$c->name}} </p>
                        </div>
                    @auth
                    @if(Auth::user()->role == "admin")
                        <div class="switch-btn">
                            <i id="up" class="up-arrow fas fa-arrow-up"></i>
                            <i id="down" class="down-arrow fas fa-arrow-down"></i>
                        </div>
                    @endif
                    @endauth
                    </div>
                    <p id="desc"> {{$c->desc}} </p>
                    <hr />
                </a>
                <div id="recentlyUpdated" class="col-2">
                    <p class="recentTitle"> Why is my dog.. </p>
                    <p class="recentPoster"> Ixinon, 35m ago </p>
                </div>
                <div id="threads" class="col-1">
                    <p> 305 </p>
                </div>
                @endforeach
                @endif
        </div>
        @auth
        @if(Auth::user()->role == "admin")
        <div id="categoryFormOpener">
            <i class="fas fa-plus"></i>
            <h1> Post new Category </h1>
        </div>
        @endif
        @endauth
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="color" content="{{$color}}">
<meta name="editor-mode" content="{{$editormode}}">
<script src="{{asset('js/categories.js')}}"> </script>
@stop