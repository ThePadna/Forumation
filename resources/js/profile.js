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
    score = $('meta[name="score"]').attr('content');

    let $posts = $('#posts>p'),
    $threads = $('#threads>p'),
    $score = $('#score>p');


    animateCounting($posts, posts);
    animateCounting($threads, threads);
    animateCounting($score, score);
}

function animateCounting($obj, count) {
    console.log(count);
    if(count == 0) {
        $obj.text(count);
        return;
    }
    $({count: 0}).animate({count: count - (count / 5)}, {
        duration: 500,
        easing: 'linear',
        step: function() {
          $obj.text(Math.round(this.count));
        },
        complete: function() {
            $({count: $obj.text()}).animate({count: count}, {
                duration: 1000,
                easing: 'linear',
                step: function() {
                  $obj.text(Math.round(this.count));
                }
            });
        }
    });
}