@extends('layouts/forum_layout')
@section('content')
<head>
    <link rel="stylesheet" href="{{asset('css/users.css')}}">
</head>
<table>
  <tr>
    <th>Username</th>
    <th>Registered</th>
    <th>Last Login</th>
  </tr>
  @foreach($users as $u)
  <tr>
    <td>{{$u->name}}</td>
    <td>{{$u->created_at}}</td>
    <td>{{$u->last_login}}</td>
  </tr>
  @endforeach
</table> 
@stop