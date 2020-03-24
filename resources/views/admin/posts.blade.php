@extends('layouts/forum_layout')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/posts.css')}}">
</head>
<div id="user-search">
<input id="search-box">
<i class="fas fa-search"></i>
</div>
<table>
  <tr>
    <th>Username</th>
    <th>Registered</th>
    <th>Last Login</th>
  </tr>
  @foreach($posts as $p)
  <tr>
    <td> <a href="">{{$p->contents}} </a> </td>
    <td>{{$p->created_at}}</td>
    <td>{{$p->updated_at}}</td>
  </tr>
  @endforeach
    @if($page > 1)
    <a href="{{$page < 2 ? 1 : $page - 1}}">
        <div id="prevpage">
            <i class="fas fa-long-arrow-alt-left"></i>
        </div>
    </a>
    @endif
    @if(sizeof($posts) >= 20)
    <a href="{{$page + 1}}">
        <div id="nextpage">
            <i class="fas fa-long-arrow-alt-right"></i>
        </div>
    </a>
    @endif
</table> 
<meta name="color" content="{{$settings->color}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/posts.js')}}"> </script>
<meta name="csrf" content="{{csrf_token()}}">
@stop