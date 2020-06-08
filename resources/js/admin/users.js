
/**
 * Listen for search-box input, query DB for posts if conditions are met.
 */
$('.search-box').val("");
$(".search-box").on("change keyup paste", function() {
    $('.temp').remove();
    if($(this).val().length < 1) {
        $('.content').show();
    }
    if($(this).val().length >= 3) {
        queryUsersDB($(this).val());
    }
})
updateColorScheme($('meta[name="color"]').attr('content'));

/**
 * Query database for users containing string val
 * 
 * @param {String} val
 */
function queryUsersDB(val) {
    $.ajax({
        type: "POST",
        url: '/queryusers',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
        data: {"val" : val},
        success: function(res) {
            if(res != '') {
                $jsonResult = JSON.parse(res);
                console.log($jsonResult);
                $jsonResult.forEach(r => {
                    let html = `<tr class="temp">
                    <td> <i class="fas fa-search"></i> ` + `<a href="/forum/profile/ ` + r[0] + `">` + r[0] + `</a> </td>
                    <td> ` + r[1] + ` </td>
                    <td> ` + r[2] + ` </td>
                    </tr>`;
                    $(html).prependTo('table');
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log("Error occured during AJAX request, error code: " + xhr.status);
        },
    });
}

/**
 * Updates color scheme on present selectors.
 * 
 * @param {String} (hex) color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
}