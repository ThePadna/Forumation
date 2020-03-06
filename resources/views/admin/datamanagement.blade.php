@extends('layouts/forum_layout')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
</head>
<div id="container">
    <div id="menu" class="row">
        <a style="color: black; text-decoration: none;" href="/forum/admin/datamanagement" class="col-sm-4">
        <div >
                <i class="fas fa-database"></i>
                <p> Data Management </p>
        </div>
        </a>
        <div class="col-sm-4">
                <div class="pickr"> To be replaced </div>
                <p> Color Scheme </p>
                <p id="color-state" class="state"> </p>
        </div>
        <div class="col-sm-4">
            <div id="sliderDiv">
                <label class="toggle">
                <input id="toggle" type="checkbox"/>
                <span class="slider"></span>
            </div>
    </label>
            </label>
                <p> Editor Mode </p>
                <p id="editor-state" class="state"> </p>
        </div>
    </div>
</div>
<meta name="color" content="{{$settings->color}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/datamanagement.js')}}"> </script>
@stop