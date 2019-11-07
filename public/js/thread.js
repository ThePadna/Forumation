/**
 * Request to post thread reply when form is submitted
 */
$replyForm = $('#replyForm');
$replyForm.submit((e) => {
    e.preventDefault();
    $text = $replyForm.find('textarea[name="replyText"]').val();
    $.ajax({
        type: "POST",
        url: '/postreply',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')},
        data: {'text': $text, 'thread': $('meta[name="thread"]').attr('content')},
        success: function(res) {
          window.location.reload();
          console.log(res);
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log("Error occured during AJAX request, error code: " + xhr.status);
        },
    });
});