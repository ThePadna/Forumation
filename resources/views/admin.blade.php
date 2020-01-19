@extends('layouts/forum_layout')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <link rel="stylesheet" href="../../node_modules/@simonwep/pickr/dist/themes/classic.min.css">
</head>
<div id="container">
    <div id="menu" class="row">
        <div class="col-sm-4">
            <a href="">
                <i class="fas fa-database"></i>
                <p> Data Management </p>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="">
                <div class="pickr"> To be replaced </div>
                <p> Color Scheme </p>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="">
            <label class="switch">
                <input type="checkbox" />
                <div></div>
            </label>
                <p> Editor Mode </p>
            </a>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script type="module" src="../../node_modules/@simonwep/pickr"></script>
<meta name="csrf" content="{{csrf_token()}}">
<script src="{{asset('js/admin.js')}}"> </script>
@stop