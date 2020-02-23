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

$('.star-symbol').on('click', (e) => {
  let $star = $(e.target);
  likePost($star, $star.attr('post'), $star.hasClass('far') ? 1 : 0);
});

function starAnim($star) {
  if($star.hasClass('far')) {
    $star.removeClass('far');
    $star.addClass('fas');
    $star.addClass('increase-size');
    setTimeout(() => {
      $star.removeClass('increase-size');
      $star.addClass('decrease-size');
      setTimeout(() => {
        $star.removeClass('decrease-size');
      }, 250);
    }, 250);
  } else {
    $star.removeClass('fas');
    $star.addClass('far');
  }
}

/**
 * 
 * @param {int} id 
 * @param {boolean} like 
 * 
 * Make POST request to like or unlike post (like = 1 || 0)
 */
function likePost($star, id, liked) {
  $.ajax({
    type: "POST",
    url: '/likepost',
    headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
    data: {
      id:id,
      liked:liked
    },
    success: function(res) {
      starAnim($star);
      $star.parent().find('.star-count').text(res);
    },
    error: function(xhr, ajaxOptions, thrownError) {
      console.log("Error occured during AJAX request, error code: " + xhr.status);
    },
  });
}
updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
  $('#header').css('background', color);
  $('.star-symbol, .star-count').css('color', color);
}