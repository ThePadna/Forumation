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
    <hr />
    <div id="thread-settings" class="row">
        <div class="col-sm-4">
        <h1 id="settings-title"> Thread </h1>
        <div id="thread-title-length">
            <h1> Thread Title Length </h1>
            <input id="thread-title-input" />
        </div>
        <div id="thread-op-post-length">
            <h1> Thread OP Post Length </h1>
            <input id="thread-op-post-input" />
        </div>
        <div id="thread-post-length">
            <h1> Thread Post Length </h1>
            <input id="thread-post-input" />
        </div>
    </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
@if($settings != null)
<meta name="color-scheme" content="{{$settings->color}}">
<meta name="editor-mode" content="{{$settings->editormode}}">
@endif
<script src="{{asset('js/admin.js')}}"> </script>
@stop