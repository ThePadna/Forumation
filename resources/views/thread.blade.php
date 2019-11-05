@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/thread.css')}}">
<div id="wrapper">
    @foreach($posts as $p)
    <div id="container">
        <div class="row">
            <div class="col-sm-2">
                <p> {{App\User::find($p->user)->name}} </p>
            </div>
            <div class="col-sm-10">
                {{$p->contents}}
            </div>
        </div>
    </div>
    @endforeach
    @if($isLastPage)
    <h1> last page lul <h1>
    @endif
</div>
@stop