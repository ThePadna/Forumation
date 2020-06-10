@extends('layouts/forum_layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/post.css')}}">
<!-- Post Form -->
<div id="wrapper">
    <div id="post">
        <form>
            <input id="threadTitle" name="threadTitle" type="text" placeholder="The title of your post" /> <br />
            <textarea id="threadText" name="threadText" cols="50" rows="10"></textarea> <br />
            <button id="postThread"> POST </button>
        </form>
    </div>
</div>
<!-- Post Form -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<meta name="csrf" content="{{csrf_token()}}">
<meta name="color" content="{{$settings->color}}">
<meta name="thread-length" content="{{$settings->thread_post_length}}">
<meta name="title-length" content="{{$settings->thread_title_length}}">
<script>
const BANNED_CHARACTERS = ["/", "\\", "#", "@", "~"];
const $form = $('form');

/**
 * Listen for submission of post thread form.
 */
$form.submit((e) => {
  e.preventDefault();
  let $text = $form.find('textarea[name="threadText"]').val();
  let $title = $form.find('input[name="threadTitle"]').val();
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
        if(res != -1) window.location.replace("/forum/category/{{$categoryURL}}/thread/" + res + "/1");
        else {
           window.location.replace("/forum/category/{{$categoryURL}}/1");
            }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log("Error occured during AJAX request, error code: " + xhr.status);
      },
  });
});

/**
 * Listen for edit of text box, warn if user enters any illegal characters or too much characters.
 */
$replyForm = $('#post');
if($replyForm != null) {
  let $replyInput = $replyForm.find('#threadText');
  $replyInput.on('input', () => {
    let $limit = $('meta[name="thread-length"]').attr('content');
    let $text = $replyInput.val().length;
    if($text > $limit) {
      if($replyForm.find('.warning').length < 1) {
        $replyForm.prepend('<p class="warning" style="color: red; text-align: center;"> Post body is over the ' + $limit + ' character limit. </h1>');
      }
    } else {
      if($replyForm.find('.warning').length > 0) {
        $('.warning').remove();
      }
    }
  });
}

/**
 * Listen for edit of title, warn if user enters any illegal characters or too much characters.
 */
if($replyForm != null) {
  let $replyInput = $replyForm.find('#threadTitle');
  $replyInput.on('input', () => {
    let $limit = $('meta[name="title-length"]').attr('content');
    let $text = $replyInput.val().length;
    let bannedCharFound = false;
    $(BANNED_CHARACTERS).each(e => {
      if($replyInput.val().includes(BANNED_CHARACTERS[e])) {
        bannedCharFound = true;
        return;
      }
    });
    if(bannedCharFound && $replyForm.find('.warning-invalid-char').length == 0) {
      $replyForm.prepend('<p class="warning-invalid-char" style="color: red; text-align: center;"> Post title cannot include any banned characters: ' + BANNED_CHARACTERS.join(" ") + ' </h1>');
    }
    if($replyForm.find('.warning-invalid-char').length > 0 && !bannedCharFound) {
        $('.warning-invalid-char').remove();
    }
    if($text > $limit) {
      if($replyForm.find('.warning').length < 1) {
        $replyForm.prepend('<p class="warning" style="color: red; text-align: center;"> Post title is over the ' + $limit + ' character limit. </h1>');
      }
    } else {
      if($replyForm.find('.warning').length > 0) {
        $('.warning').remove();
      }
    }
  });
}

updateColorScheme($('meta[name="color"]').attr('content'));

/**
 * Updates color scheme on present selectors.
 * 
 * @param {String} (hex) color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
}
</script>
@stop