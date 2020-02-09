updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
    $('p').css('color', color);
}
/**
 * Load all Posts, Threads, and Scores for user
 * Increment them to retrieved value as a displaying animation
 */
function displayStats() {
    let posts, threads, scores;
}