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
    <div class="row settings-footer">
        <div class="col-sm-4">
            <div class="thread-settings-wrapper">
                <h1 class="settings-title"> Thread </h1>
                <div class="setting">
                    <h1 id="thread-title-length" class="option"> Thread Title Length </h1>
                    <input class="value" id="thread-title-input" value="{{$settings->thread_title_length}}"
                        id="thread-title-input" />
                </div>
                <div class="setting">
                    <h1 id="thread-op-length" class="option"> Thread OP Post Length </h1>
                    <input class="value" id="thread-op-input" value="{{$settings->thread_op_length}}"
                        id="thread-op-post-input" />
                </div>
                <div class="setting">
                    <h1 id="thread-post-length" class="option"> Thread Post Length </h1>
                    <input class="value" id="thread-post-input" value="{{$settings->thread_post_length}}"
                        id="thread-post-input" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="profile-settings-wrapper">
                <h1 class="settings-title"> Profile </h1>
                <div class="setting">
                    <h1 id="profile-name-length" class="option"> Username Length </h1>
                    <input class="value" id="profile-name-input" value="{{$settings->profile_name_length}}"
                        id="thread-title-input" />
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div id="result-placement"> </div>
        <button class="submit-settings"> SAVE SETTINGS </button>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
    <meta name="csrf" content="{{csrf_token()}}">
    @if($settings != null)
    <meta name="color-scheme" content="{{$settings->color}}">
    <meta name="editor-mode" content="{{$settings->editormode}}">
    @endif
    <script src="{{asset('js/admin.js')}}"> </script>
    @stop