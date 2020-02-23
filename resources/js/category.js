
updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Change colour to forum's color scheme on hover.
 */
$('.edit-btn').on('mouseover', (e) => {
    $(e.target).css({
        color: $('meta[name="color"]').attr('content'),
        transition: 'color 1s'
    });
});
$('.edit-btn').on('mouseout', (e) => {
    $(e.target).css({
        color: 'black',
        transition: 'color 1s'
    });
});
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
    $('#prevpage, #nextpage, #postThread>*, p').css('color', color);
}
