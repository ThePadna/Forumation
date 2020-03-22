
$('#search-box').val("");
$("#search-box").on("change keyup paste", function() {
    $('.temp').remove();
    if($(this).val().length >= 3) {
        queryUsersDB($(this).val());
    }
})

function queryUsersDB(val) {
    $.ajax({
        type: "POST",
        url: '/queryposts',
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
                    $(html).appendTo('table');
                });
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