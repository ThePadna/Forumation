updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Updates color scheme on present selectors.
 * 
 * @param {String} (hex) color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
    $('.menu-item').css('color', color);
}