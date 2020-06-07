@extends('layouts/forum_layout')
@section('content')

<head>
    <link rel="stylesheet" href="{{asset('css/posts.css')}}">
</head>
<table>
    <tr>
        <th>
            <div id="user-search">
                <input id="search-box">
                <i class="fas fa-search"></i>
            </div>
        </th>
    </tr>
    <tr>
        <th>Username</th>
        <th>Registered</th>
        <th>Last Login</th>
    </tr>
    @foreach($posts as $p)
    @php
    $contents = $p->contents;
    if(strlen($contents) > 40) {
      $contents = rtrim(substr($contents, 0, 40), " ") . "...";
    }
    $thread = App\Models\Thread::find($p->thread);
    $category = App\Models\Category::find($thread->categoryId)->name;
    $allPosts = App\Models\Post::where('thread', $thread->id)->get();
    $i = 0;
    $page = 0;
    foreach($allPosts as $p1) {
        $i++;
        if($p->id == $p1->id) {
            $page = ceil($i / 9);
            break;
        }
    }
    @endphp
    <tr>
        <td> <a href="/forum/category/{{$category}}/thread/{{str_replace(' ', '-', substr($thread->title, 0, 20))}}-{{$thread->id}}/{{$page}}">{{$contents}} </a> </td>
        <td>{{$p->created_at}}</td>
        <td>{{$p->updated_at}}</td>
    </tr>
    @endforeach
</table>
<!-- Page selector -->
@php
  $displayNumbers = array();
  for($x = $page - 2; $x <= $page + 2; $x++) {
      if($x > $lastPage || $x <= 0) continue;
      $displayNumbers[$x] = $x;
  }
  $uri = "/forum/admin/datamanagement/posts/";
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
<meta name="color" content="{{$settings->color}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="{{asset('js/posts.js')}}"> </script>
<meta name="csrf" content="{{csrf_token()}}">
@stop