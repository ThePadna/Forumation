let $usernameInp = $('#usernameInput');
let $picInp = $('#avatar-input');
updateColorScheme($('meta[name="color"]').attr('content'));
$usernameInp = $('#username-input');
if($usernameInp != null) {
  $usernameInp.on('input', () => {
    let $limit = $('meta[name="username-length"]').attr('content');
    let $text = $usernameInp.val().length;
    if($text > $limit) {
      if($('.warning').length < 1) {
        $('.error-container').append('<p class="warning" style="color: red; text-align: center;"> Your username is over the ' + $limit + ' character limit. This will not be updated. </h1>');
      }
    } else {
      console.log($text + " " + $limit);
      if($('.warning').length > 0) {
        $('.warning').remove();
      }
    }
  });
}
$('form').submit((e) => {
    e.preventDefault(); 
    var formData = new FormData();
    let $name = $usernameInp.val();
    let $rank = $('.selected-rank').attr('rankId');
    console.log("name;" + $name);
    if($name != null) formData.append("username", $name);
    let $src = $('#avatar').attr('src');
    if($src != null) formData.append("pic", $src);
    if($rank != -1) formData.append("rank", $rank);
    $.ajax({
        type: "POST",
        url: '/profile/' + $('meta[name="userId"]').attr('content') + '/edit/updateprofile',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
          window.location = "/profile/" + res;
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log("Error occured during AJAX request, error code: " + xhr.status);
        },
      });
});
$('#avatar-input').change((e) => {
  let reader = new FileReader();
  reader.onload = function(e) {
      $('#avatar').attr('src', e.target.result);
  }
  reader.readAsDataURL(e.target.files[0]);
});
$('.dropdown-item').on('click', e => {
  let $rId = $(e.target).attr('id');
  let $rName = $(e.target).text();
  $('.selected-rank').attr('rankId', $rId);
  $('.selected-rank').text($rName);
});
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
}
