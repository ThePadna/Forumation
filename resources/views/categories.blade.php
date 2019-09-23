@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<div id="wrapper">
    <div id="categories">
        @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
            @else
            @foreach($categories as $c)
            <a categoryId="{{$c->id}}" href="/category/{{$c->name}}">
                <div id="category" class="drop-zone" draggable="true">
                    <p categoryId="{{$c->id}}"> {{$c->name}}</p>
                    @auth
                    <i class="far fa-edit"></i>
                    <i class="fas fa-trash"></i>
                    @endauth
                </div>
            </a>
            @endforeach
            @endif
            @auth
            @if(Auth::user()->role == "admin")
            <!-- show box -->
            @endif
            @endauth
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<form id="addCategoryForm">
Input new Category name <br />
<input id="categoryTitle" type="text" name="categoryname"/>
<button id="categoryFormCloser"> Submit </button>
</form>
<button id="categoryFormOpener"> Add new Category </button>
<script>
var $form = $('#addCategoryForm');
$form.hide();
$form.submit((e) => {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: 'postcategory',
        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
        data: $form.serialize(),
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
var $categoryFormOpener = $('#categoryFormOpener').click(() => {
    $form.show();
    $categoryFormOpener.hide();
});
var dragged;
document.addEventListener("dragstart", function(event) {
  dragged = event.target;
}, false);
document.addEventListener("drop", function(event) {
  event.preventDefault();
  event.target.style.background = "white";
  var node = event.target.nodeName;
  var targetElement;
  if(node.localeCompare("P") === 0) targetElement = event.target.parentElement.parentElement;
  else if(node.localeCompare("DIV") == 0) targetElement = event.target.parentElement;
  var targetInnerHTML = targetElement.innerHTML, targetHREF = targetElement.href;
  targetElement.innerHTML = dragged.innerHTML;
  dragged.innerHTML = targetInnerHTML
  targetElement.href = dragged.href;
  dragged.href = targetHREF;
  $.ajax({
        type: "POST",
        url: 'categoryswitchid',
        headers: {
          'X-CSRF-TOKEN' : '{{csrf_token()}}',
          'Content-Type' : 'application/json'
        },
        data: {
          "draggedId" : dragged.getAttribute("categoryId"),
          "targetId" : targetElement.getAttribute("categoryId")
        },
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
}, false);
document.addEventListener("dragover", function(event) {
  event.preventDefault();
}, false);
document.addEventListener("dragenter", function(event) {
  if (event.target.className == "drop-zone") {
    event.target.style.background = "gray";
  }

}, false);
document.addEventListener("dragleave", function(event) {
  if (event.target.className == "drop-zone") {
    event.target.style.background = "white";
  }

}, false);
</script>
@stop