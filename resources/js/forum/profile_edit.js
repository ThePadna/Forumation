let $usernameInp = $('#usernameInput');
let $picInp = $('#profilepic');
updateColorScheme($('meta[name="color"]').attr('content'));
$('form').submit((e) => {
    e.preventDefault(); 
    var formData = new FormData();
    let $name = $usernameInp.val();
    console.log("name;" + $name);
    if($name != null) formData.append("username", $name);
    let $src = $picInp.attr('src');
    if($src != null) formData.append("pic", $src);
    $.ajax({
        type: "POST",
        url: '/forum/profile/' + $('meta[name="userId"]').attr('content') + '/edit/updateprofile',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
          window.location = "/forum/profile/" + $('meta[name="userId"]').attr('content');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log("Error occured during AJAX request, error code: " + xhr.status);
        },
      });
});
$('#pic').change((e) => {
  var reader = new FileReader();
  reader.onload = function(e) {
      $('#profilepic').attr('src', e.target.result);
  }
  reader.readAsDataURL(e.target.files[0]);
});
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
}