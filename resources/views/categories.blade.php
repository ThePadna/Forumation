<html>
@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<form id="addCategoryForm">
input category name
<input id="categoryTitle" type="text" name="categoryname"/>
</form>
<script>
var frm = $('#addCategoryForm');
frm.submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: '/postcategory',
        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
        data: frm.serialize(),
        success: function (data) {
            console.log('Submission was successful.');
            alert(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('An error occurred.');
            console.log(errorThrown);
            console.log(jqXHR);
        },
    });
});
</script>
<div id="wrapper">
    <div id="categories">
        @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
            @else
            @foreach($categories as $c)
            <a href="/category/{{$c->id}}">
                <div id="category">
                    <div id="name">
                        <p> {{$c->name}}</p>
                    </div>
                </div>
            </a>
            @endforeach
            @endif
            @auth
            @if(Auth::user()->role == "admin")
            <!-- show box -->
            @endif
            @endauth
            @stop
    </div>
</div>

<script>
function popup($item, visible) {
    if (visible) $item.style.visibility = "visible";
    else $item.style.visibility = "hidden";
}
</script>

</html>