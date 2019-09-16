@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/categories.css')}}">
<div id="wrapper">
    <div id="categories">
        @if(sizeof($categories) < 1) <h1> No Categories found. </h1>
            @else
            @foreach($categories as $c)
            <a categoryId="{{$c->id}}" href="/category/{{$c->id}}">
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
        url: '/postcategory',
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
document.addEventListener("dragstart", function(event) {
  var categoryId = event.target.getAttribute("categoryId");
  console.log("Drag");
  event.dataTransfer.setData("id", categoryId);
}, false);
document.addEventListener("drop", function(event) {
  event.preventDefault();
  event.target.style.background = "white";
  var droppedId = event.dataTransfer.getData("id");
  var node = event.target.nodeName;
  var targetId = null;
  if(node.localeCompare("P") === 0) targetId = event.target.parentElement.parentElement.getAttribute("categoryId");
  else if(node.localeCompare("DIV") == 0) targetId = event.target.parentElement.getAttribute("categoryId");
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