@extends('layouts/forum_layout')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
</head>
<div id="container">
    <div id="menu" class="row">
        <div class="col-sm-4">
                <i class="fas fa-database"></i>
                <p> Data Management </p>
        </div>
        <div class="col-sm-4">
                <div class="pickr"> To be replaced </div>
                <p> Color Scheme </p>
        </div>
        <div class="col-sm-4">
            <div id="sliderDiv">
                <label class="toggle">
                <input type="checkbox"/>
                <span class="slider"></span>
            </div>
    </label>
            </label>
                <p> Editor Mode </p>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<script src="{{asset('js/admin.js')}}"> </script>
@stop