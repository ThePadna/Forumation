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