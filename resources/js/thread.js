let erasePostFormHTML = `<div id="erasePostForm" class="popup-form">
<div class="form-header">
    <div class="form-exit">
        <i id="exit-icon" class="fas fa-times"></i>
    </div>
    <h1> Erase Post </h1>
</div>
<div class="form-container">
    <form>
        <p> Are you sure you would like to erase this post? </p>
        <button id="erasePostConfirmation"> Confirm </button>
    </form>
</div>
</div>`;

let $prevClickedIconPostId;
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

let $erasePostForm;
function initForms() {
    $erasePostForm = $("#erasePostForm");
}

$('.erase').on('click', e => {
  $("body").append(erasePostFormHTML);
  registerFormExitHandler();
  initForms();
  registerErasePostSubmitListener();
  updateColorScheme($('meta[name="color"]').attr('content'));
});

$(document).on('mouseover', '.form-exit', (e) => {
  $(e.target).css({
      color: 'red',
      transition: 'color 1s'
  });
});
$(document).on('mouseout', '.form-exit', (e) => {
  $(e.target).css({
      color: 'gray',
      transition: 'color 1s'
  });
});

/**
 * Listen for form submission
 * Request to post erase post when form is submitted.
 */
function registerErasePostSubmitListener() {
  $erasePostForm.submit(e => {
      e.preventDefault();
      $.ajax({
          type: "POST",
          url: "/erasePost",
          headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
          data: { id: $prevClickedIconPostId},
          success: function(res) {
              window.location.reload();
          },
          error: function(xhr, ajaxOptions, thrownError) {
              console.log(
                  "Error occured during AJAX request, error code: " +
                      xhr.status
              );
          }
      });
  });
}
/**
 * Register click handler every time we append form to DOM.
 */
function registerFormExitHandler() {
  $(".form-exit").on("click", e => {
      $(".popup-form").remove();
  });
}
/**
 * Change colour to forum's color scheme on hover.
 */
$('.edit-btn, .post-edit').on('mouseover', (e) => {
  $(e.target).css({
      color: $('meta[name="color"]').attr('content'),
      transition: 'color 1s'
  });
});
$('.edit-btn, .post-edit').on('mouseout', (e) => {
  $(e.target).css({
      color: 'black',
      transition: 'color 1s'
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
  $('#header, .popup-form').css('background', color);
  $('.star-symbol, .star-count').css('color', color);
}