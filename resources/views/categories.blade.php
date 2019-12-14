@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<div id="wrapper">
    <div id="categories">
        <div class="row">
            @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
                @else
                @foreach($categories as $c)
                <div id="title" class="drop-zone col-sm-8" ondragover="event.preventDefault()" draggable="true">
                    <p categoryId="{{$c->id}}"> {{$c->name}}</p>
                    @auth
                    @if(Auth::user()->role == "admin")
                    <i class="edit-category far fa-edit"></i>
                    <i class="del-category fas fa-trash"></i>
                    @endif
                    @endauth
                </div>
                <div id="recentlyUpdated" class="col-sm-2">
                    <p class="header"> Latest post</p>
                    <p> Why is my dog.. </p>
                    </p> Ixinon, 35m ago </p>
                </div>
                <div id="threads" class="col-sm-1">
                <p class="header"> Threads </p>
                <p> 305 </p>
                </div>
                @endforeach
                @endif
        </div>
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
                    <input id="categoryTitle" type="text" name="categoryTitle" />
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
        <div id="editCategoryForm" class="popup-form">
            <div class="form-header">
                <div class="form-exit">
                    <i id="exit-icon" class="fas fa-times"></i>
                </div>
                <h1> Edit Category </h1>
            </div>
            <div class="form-container">
                <form>
                    <input type="text" name="categoryname" />
                    <button id="categoryFormCloser"> Confirm Edit </button>
                </form>
            </div>
        </div>
        <a>
            <i id="categoryFormOpener" class="far fa-plus-square"></i>
        </a>
        @endif
        @endauth
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<script src="{{asset('js/categories.js')}}"> </script>
@stop