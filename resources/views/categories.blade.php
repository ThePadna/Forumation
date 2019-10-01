@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<div id="wrapper">
    <div id="categories">
        @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
            @else
            @foreach($categories as $c)
            <a class="category-hyperlink" categoryName="{{$c->name}}" categoryId="{{$c->id}}" href="/category/{{$c->name}}">
                <div class="category drop-zone" draggable="true">
                    <p categoryId="{{$c->id}}"> {{$c->name}}</p>
                    @auth
                    @if(Auth::user()->role == "admin")
                    <i class="edit-category far fa-edit"></i>
                    <i class="del-category fas fa-trash"></i>
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
            <div id="delCategoryForm" class="popup-form">
                <div class="form-header">
                    <div class="form-exit">
                        <i id="exit-icon" class="fas fa-times"></i>
                    </div>
                    <h1> Delete Category </h1>
                </div>
                <div class="form-container">
                    <form>
                        <h2> Delete Category '%c'? </h2>
                        <button id="categoryFormCloser"> Confirm Deletion </button>
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