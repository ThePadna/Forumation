@extends('layouts/forum_layout')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/users.css')}}">
</head>
<!-- Page selector -->
@php
  $displayNumbers = array();
  for($x = $page - 2; $x <= $page + 2; $x++) {
      if($x > $lastPage || $x <= 0) continue;
      $displayNumbers[$x] = $x;
  }
  $uri = "/forum/admin/datamanagement/users/";
@endphp
@if($page > 0)
<div class="page-selector">
  <p class="page-info"> Page {{$page}} of {{$lastPage}} </p>
  <div class="selectors">
  @if($lastPage > 3)
  <a href="{{$uri . 1}}">
  <div class="selector-wrapper">
      <h1 class="selector"> < </h1>
  </div>
  </a>
  @endif
  @foreach($displayNumbers as $num)
      @if($page == $num)
      <div class="selector-wrapper" style="border: 1px solid #007bff;">
      @else
      <a href="{{$uri . $num}}"> 
      <div class="selector-wrapper">
      @endif
          <h1 class="selector"> {{$num}} </h1>
      </div>
      </a>
  @endforeach
  @if($lastPage > 3)
  <a href="{{$uri . $lastPage}}">
  <div class="selector-wrapper">
      <h1 class="selector"> > </h1>
  </div>
  </a>
  @endif
  </div>
  </div>
@endif
<!-- Page selector -->

<!-- Search Box -->
<div id="search-wrapper">
    <input class="search-box">
    <i class="fas fa-search"></i>
</div>
<!-- Search Box -->

<table>
  <tr>
    <th>Username</th>
    <th>Registered</th>
    <th>Last Login</th>
  </tr>
  @foreach($users as $u)
  <tr class="content">
    <td> <a class="username" href="/forum/profile/{{$u->name}}">{{$u->name}} </a> </td>
    <td>{{$u->created_at}}</td>
    <td>{{$u->last_login}}</td>
  </tr>
  @endforeach
</table> 
<meta name="color" content="{{$settings->color}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/users.js')}}"> </script>
<meta name="csrf" content="{{csrf_token()}}">
@stop