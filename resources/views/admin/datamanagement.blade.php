@extends('layouts/forum_layout')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/datamanagement.css')}}">
</head>
<div id="container">
    <div id="menu" class="row">
        <a href="/forum/admin/datamanagement/users/1" class="col-sm-4 menu-item">
        <i class="fas fa-users"></i>
                <p> Users </p>
        </a>
        <a href="/forum/admin/datamanagement/threads/1" class="col-sm-4 menu-item">
        <i class="fas fa-comments"></i>
                <p> Threads </p>
        </a>
        <a href="/forum/admin/datamanagement/posts/1" class="col-sm-4 menu-item">
        <i class="far fa-address-card"></i>
            <p> Posts </p>
        </a>
    </div>
</div>
<meta name="color" content="{{$settings->color}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/datamanagement.js')}}"> </script>
@stop