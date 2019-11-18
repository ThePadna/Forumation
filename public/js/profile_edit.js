let $pic_changed = null, $name_changed = null;

$('form').submit((e) => {
    e.preventDefault(); 
    let formData = new FormData();
});

$('#pic').change((e) => {
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#profilepic').attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
    this.$pic_changed = e.target.files[0];
});

$('')