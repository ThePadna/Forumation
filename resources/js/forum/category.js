let delThreadFormHTML = `<div id="delThreadForm" class="popup-form">
<div class="form-header">
    <div class="form-exit">
        <i id="exit-icon" class="fas fa-times"></i>
    </div>
    <h1> Delete Thread </h1>
</div>
<div class="form-container">
    <form>
        <h2> Delete Thread '%t'? </h2>
        <button id="categoryFormCloser"> Confirm Deletion </button>
    </form>
</div>
</div>`;
let $prevClickedDelThreadName, $prevClickedDelThreadId;
updateColorScheme($('meta[name="color"]').attr('content'));
$('#post-thread-input').on('click', e => {
    console.log("ho");
    window.location = "/forum/category/" + $('meta[name="category"]').attr('content') + "/post";
});
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
 * Initialize forms that are used when a 'popup-form' is needed.
 */
let $delThreadForm;
function initForms() {
    $delThreadForm = $("#delThreadForm");
}
/**
 * Listen for form submission
 * Request to delete category when form is submitted.
 */
function registerDelFormSubmitListener() {
    $delThreadForm.submit(e => {
        e.preventDefault();
        console.log("sbit");
        $.ajax({
            type: "POST",
            url: "/delthread",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
            data: { id: $prevClickedDelThreadId.trim() },
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
$(".del-thread").on("click", e => {
    e.preventDefault();
    $prevClickedDelThreadId = $(e.target).attr('threadId');
    $prevClickedDelThreadName = $(e.target).attr('threadName');
    $("#threads").append(
        delThreadFormHTML.replace(
            "%t",
            $prevClickedDelThreadName.trim()
        )
    );
    registerFormExitHandler();
    initForms();
    registerDelFormSubmitListener();
    updateColorScheme($('meta[name="color"]').attr('content'));
});
/**
 * Register click handler every time we append form to DOM.
 */
function registerFormExitHandler() {
    $(".form-exit").on("click", e => {
        $(".popup-form").remove();
    });
}

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
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
    $('#header, .popup-form').css('background', color);
    $('#prevpage, #nextpage, #postThread>*, p').css('color', color);
}
