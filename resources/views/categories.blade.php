@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<div id="wrapper">
    <div id="categories">
        @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
            @else
            @foreach($categories as $c)
            <a categoryId="{{$c->id}}" href="/category/{{$c->name}}">
                <div id="category" class="drop-zone" draggable="true">
                    <p categoryId="{{$c->id}}"> {{$c->name}}</p>
                    @auth
                    <i class="far fa-edit"></i>
                    <i class="fas fa-trash"></i>
                    @endauth
                </div>
            </a>
            @endforeach
            @endif
            @auth
            @if(Auth::user()->role == "admin")
            <!-- show box -->
            @endif
            @endauth
    </div>
</div>
<form id="addCategoryForm">
Input new Category name <br />
<input id="categoryTitle" type="text" name="categoryname"/>
<button id="categoryFormCloser"> Submit </button>
</form>
<button id="categoryFormOpener"> Add new Category </button>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<script src="{{asset('js/categories.js')}}"> </script>
@stop