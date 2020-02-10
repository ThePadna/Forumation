updateColorScheme($('meta[name="color"]').attr('content'));
displayStats();
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
    let posts = $('meta[name="posts"]').attr('content'),
    threads = $('meta[name="threads"]').attr('content'),
    score = $('meta[name="scores"]').attr('content');

    let $posts = $('#posts>p'),
    $threads = $('#threads>p'),
    $score = $('#score>p');
    $({posts: 0}).animate({posts: posts}, {
        duration: 500,
        easing:'linear',
        step: function() {
          $posts.text(Math.round(this.posts));
        }
    });

    $({threads: 0}).animate({threads: threads}, {
        duration: 500,
        easing:'linear',
        step: function() {
          $threads.text(Math.round(this.threads));
        }
    });

    $({score: 0}).animate({score: score}, {
        duration: 500,
        easing:'linear',
        step: function() {
          $score.text(Math.round(this.score));
        }
    });
}