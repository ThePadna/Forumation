@extends('layouts/forum_layout')
@section('content')

<head>
    <link rel="stylesheet" href="{{asset('css/ranks.css')}}">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
</head>
<table>
  <tr>
    <th>Rank</th>
    <th>Color</th>
    <th>Permissions</th>
  </tr>
  @foreach($ranks as $r)
  <tr>
    <td>{{$r->name}}</td>
    <td id="color{{$r->id}}" class="color">{{$r->color}}</td>
    <td>{{$r->name}}</td>
  </tr>
  @endforeach
</table>
<meta name="color" content="{{$settings->color}}">
<script src="{{asset('js/ranks.js')}}"> </script>
<meta name="csrf" content="{{csrf_token()}}">
@stop