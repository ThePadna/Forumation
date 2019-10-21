var $form = $('form');
$form.submit((e) => {
  e.preventDefault();
  $.ajax({
      type: "POST",
      url: '/postthread',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')},
      data: {"test": "data"},
      success: function(res) {
        window.location.reload();
        console.log(res);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log("Error occured during AJAX request, error code: " + xhr.status);
      },
  });
});