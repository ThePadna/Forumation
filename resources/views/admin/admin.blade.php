@extends('layouts/forum_layout')
@section('content')

<head>
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
</head>
<div id="container">
    <div id="menu" class="row">
        <a style="color: black; text-decoration: none;" href="/forum/admin/datamanagement" class="col-sm-4">
            <div id="data-mgmt">
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
                    <input id="toggle" type="checkbox" />
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
            <div>
                <h1 id="thread-title-length"> Thread Title Length </h1>
                <input id="thread-title-input" value="{{$settings->thread_title_length}}" id="thread-title-input" />
            </div>
            <div>
                <h1 id="thread-op-length"> Thread OP Post Length </h1>
                <input id="thread-op-input" value="{{$settings->thread_op_length}}" id="thread-op-post-input" />
            </div>
            <div>
                <h1 id="thread-post-length"> Thread Post Length </h1>
                <input id="thread-post-input" value="{{$settings->thread_post_length}}" id="thread-post-input" />
            </div>
            <br />
            <button id="submit-thread-settings"> SAVE </button>
            <div id="error-placement"> </div>
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