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
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="color" content="{{$color}}">
<script>
var $form = $('form');
$form.submit((e) => {
  e.preventDefault();
  var $text = $form.find('textarea[name="threadText"]').val();
  var $title = $form.find('input[name="threadTitle"]').val();
  $.ajax({
      type: "POST",
      url: '/postthread',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')},
      data: {
        'threadText': $text,
        'threadTitle': $title,
        'categoryId': '{{$categoryId}}'
        },
      success: function(res) {
        if(res != -1) window.location.replace("/forum/category/{{$categoryId}}/thread/" + res + "/1");
        else {
           window.location.replace("/forum/category/{{$categoryId}}/1");
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log("Error occured during AJAX request, error code: " + xhr.status);
      },
  });
});
updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
}
</script>
@stop