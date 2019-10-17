@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/post.css')}}">
<div id="wrapper">
    <div id="post">
        <form>
            <input id="threadTitle" name="threadTitle" type="text" placeholder="The title of your post" /> <br />
            <textarea id="threadText" name="threadText" cols="50" rows="10"></textarea> <br />
            <button id="postThread"> POST </button>
        </form>
    </div>
</div>
<meta name="csrf" content="{{csrf_token()}}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script>
var $form = $('form');
$form.submit((e) => {
    e.preventDefault();
    var $title = $form.find('input[name=threadTitle]').val();
    var $text = $form.find('textarea[name=threadText]').val();
    $.ajax({
        type: 'POST',
        url: 'postthread',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')
        },
        data: {
            'title': $title,
            'text': $text
        },
        success: function(res) {
            console.log("success");
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log("Error occured during AJAX request, error code: " + xhr.status);
        },
    });
});
</script>
@stop