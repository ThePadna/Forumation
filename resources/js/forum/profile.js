let banUserFormHTML = `<div id="banUserForm" class="popup-form">
<div class="form-header">
    <div class="form-exit">
        <i id="exit-icon" class="fas fa-times"></i>
    </div>
    <h1> Ban User </h1>
</div>
<div class="form-container">
    <form>
        <input id="cause" type="text" name="cause" placeholder="Cause" />
        <button id="confirmBan"> Confirm Ban </button>
    </form>
</div>
</div>`;

updateColorScheme($('meta[name="color"]').attr('content'));
$(document).on('mouseover', '.form-exit', (e) => {
    $(e.target).css({
        color: 'red',
        transition: 'color 1s'
    });
 });
 $(document).on('mouseout', '.form-exit', (e) => {
    $(e.target).css({
        color: 'gray',
        transition: 'color 1s'
    });
 });
displayStats();
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
    $('#header, .popup-form').css('background', color);
    $('p').css('color', color);
}
/**
 * Initialize forms that are used when a 'popup-form' is needed.
 */
let $banUserForm;
function initForms() {
    $banUserForm = $("#banUserForm");
}
/**
 * Listen for form submission
 * Request to post new category when form is submitted.
 */
function registerBanUserSubmitListener() {
    $banUserForm.submit(e => {
        e.preventDefault();
        let $cause = $banUserForm.find('input[name="cause"]').val();
        $.ajax({
            type: "POST",
            url: "/banuser",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
            data: { user:  $('meta[name="user"]').attr("content"), cause: $cause },
            success: function(res) {
                window.location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(
                    "Error occured during AJAX request, error code: " +
                        xhr.status
                );
            }
        });
    });
}
/**
 * Register click handler every time we append form to DOM.
 */
function registerFormExitHandler() {
    $(".form-exit").on("click", e => {
        $(".popup-form").remove();
    });
}

/**
 * Open user ban form on click.
 */
$("#ban-btn").on("click", e => {
    $("body").append(banUserFormHTML);
    registerFormExitHandler();
    initForms();
    registerBanUserSubmitListener();
    updateColorScheme($('meta[name="color"]').attr('content'));
    exitFormBtnHoverColorListener($('meta[name="color"]').attr('content'));
});
/**
 * Load all Posts, Threads, and Scores for user
 * Increment them to retrieved value as a displaying animation
 */
function displayStats() {
    let posts = $('meta[name="posts"]').attr('content'),
    threads = $('meta[name="threads"]').attr('content'),
    score = $('meta[name="score"]').attr('content');

    let $posts = $('.post-counter'),
    $threads = $('.thread-counter'),
    $score = $('.score-counter');


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