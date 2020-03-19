$("#search-box").on("change keyup paste", function() {
    if($(this).val().length >= 3) {
        queryUsersDB($(this).val());
    }
})

function queryUsersDB(val) {
    $.ajax({
        type: "POST",
        url: '/queryusers',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
        data: {"val" : val},
        success: function(res) {
            if(res == '') {
                $('body').append('empty');
            } else {
            $('body').append(res);
            }
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
    $('#prevpage, #nextpage').css('color', color);
}