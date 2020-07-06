/**
 * Hide messaging popup contents and set unread message notification value.
 */
$('.message-popup').hide();
$('.scroll-up').hide();
$('.notifications').text($('meta[name="unread"]').attr('content'));

/**
 * Listen for conversation click, replace conversation list with new messages list
 */
$('.conversation').on('click', e => {
    $('.conversation').hide();
    let $u1 = $(e.target.parentElement).attr('user-1'), $u2 = $(e.target.parentElement).attr('user-2');
    let $userImage = $(e.target.parentElement).find('img').attr('src');
    let yourImage = $('meta[name="avatar"]').attr('content');
    let yourName = $('meta[name="username"]').attr('content');
    $.ajax({
        type: "POST",
        url: "/queryconversation",
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
        data: {user1: $u1, user2: $u2},
        success: function(res) {
            $('.message-popup').append('<div class="return-btn"> <i class="fas fa-long-arrow-alt-left"></i> </div>')
            registerReturnListener();
            let messages = res.split(",");
            messages.forEach((e) => {
                let info = e.split(":");
                let sentBy = info[0].localeCompare(yourName) == 0 ? "you" : "user";
                let imageToUse = sentBy.localeCompare("you") == 0 ? yourImage : $userImage;
                $('.message-popup').append(`<div class="message ` + sentBy + `"> <div class="avatar"> <img src="` + imageToUse + `" /> </div> <div class="content"> <p> ` + info[1] + ` </p> </div> </div>`);
            });
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(
                "Error occured during AJAX request, error code: " +
                    xhr.status
            );
        }
    });
});

/**
 * Register listeners for exiting the message popup.
 */
function registerReturnListener() {
    $('.return-btn').on('click', () => {
        $('.message').remove();
        $('.return-btn').remove();
        $('.conversation').show();
    });
}

/**
 * Slide the message popup up or down depending on dir's value (down = true, up = false).
 * @param {boolean} dir 
 */
function slide(dir) {
    if(dir) {
        $('.message-popup').slideDown(250, () => {
            $('.scroll-up').show();
        });
    } else {
        $('.scroll-up').hide();
        $('.message-popup').slideUp(250);
    }
}

/**
 * Listen for message popup buttons.
 */
$('.inbox, .scroll-up').on('click', () => {
    if($('.message-popup').is(':hidden')) slide(true);
    else slide(false);
});