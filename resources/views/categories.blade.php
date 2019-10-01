@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<div id="wrapper">
    <div id="categories">
        @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
            @else
            @foreach($categories as $c)
            <a class="category-hyperlink" categoryId="{{$c->id}}" href="/category/{{$c->name}}">
                <div class="category" class="drop-zone" draggable="true">
                    <p categoryId="{{$c->id}}"> {{$c->name}}</p>
                    @auth
                    @if(Auth::user()->role == "admin")
                    <i id="edit-category" class="far fa-edit"></i>
                    <i id="del-category" class="fas fa-trash"></i>
                    @endif
                    @endauth
                </div>
            </a>
            @endforeach
            @endif
            @auth
            @if(Auth::user()->role == "admin")
            <div id="addCategoryForm" class="popup-form">
                <div class="form-header">
                    <div class="form-exit">
                        <i id="exit-icon" class="fas fa-times"></i>
                    </div>
                    <h1> New Category </h1>
                </div>
                <div class="form-container">
                    <form>
                        <input id="categoryTitle" type="text" name="categoryname" />
                        <button id="categoryFormCloser"> Add Category </button>
                    </form>
                </div>
            </div>
            <button id="categoryFormOpener"> Add new Category </button>
            @endif
            @endauth
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<script src="{{asset('js/categories.js')}}"> </script>
@stop