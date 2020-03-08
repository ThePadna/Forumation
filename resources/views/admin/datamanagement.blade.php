@extends('layouts/forum_layout')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
</head>
<div id="container">
    <div id="menu" class="row">
        <a href="/forum/admin/datamanagement/users/1" class="col-sm-4">
        <i class="fas fa-users"></i>
                <p> Users </p>
        </a>
        <div class="col-sm-4">
        <i class="fas fa-comments"></i>
                <p> Threads </p>
        </div>
        <div class="col-sm-4">
        <i class="far fa-address-card"></i>
            <p> Posts </p>
        </div>
    </div>
</div>
<meta name="color" content="{{$settings->color}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/datamanagement.js')}}"> </script>
@stop