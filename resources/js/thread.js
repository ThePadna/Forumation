/**
 * Request to post thread reply when form is submitted
 */
$replyForm = $('#replyForm');
$replyForm.submit((e) => {
    e.preventDefault();
    $text = $replyForm.find('#replyText').val();
    $.ajax({
        type: "POST",
        url: '/postreply',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')},
        data: {'text': $text, 'thread': $('meta[name="thread"]').attr('content')},
        success: function(res) {
          window.location.reload();
          console.log(res);
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log("Error occured during AJAX request, error code: " + xhr.status);
        },
    });
});

$('#star-symbol').on('click', (e) => {
  let $star = $(e.target);
  if($star.hasClass('far')) {
    $star.removeClass('far');
    $star.addClass('fas');
  } else {
    $star.removeClass('fas');
    $star.addClass('far');
  }
});
updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
  $('#header').css('background', color);
  $('#star').css('color', color);
}