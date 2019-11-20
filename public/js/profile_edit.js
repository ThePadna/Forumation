let $pic_changed = null, $name_changed = null;
let $usernameInp = $('#username');

$('form').submit((e) => {
    e.preventDefault(); 
    console.log("ready to send user " + $usernameInp.val());
    var formData = new FormData();
    formData.append("username", $usernameInp.val());
    formData.append("pic", $pic_changed);
    $.ajax({
        type: "POST",
        url: '/forum/profile/' + $('meta[name="userId"]').attr('content') + '/edit/updateprofile',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
          console.log(res);
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
    this.$pic_changed = e.target.files[0];
});

$usernameInp.change((e) => {
    $name_changed = $usernameInp.val();
    if(($usernameInp.val()).length == 0) $name_changed = null;
});