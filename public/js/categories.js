/**
 * Gain reference to forms and hide them in anticipation for button press.
 */
var $addCategoryForm = $('#addCategoryForm'), $delCategoryForm = $('#delCategoryForm');
$addCategoryForm.hide();
$delCategoryForm.hide();

/**
 * Request to post new category when form is submitted.
 */
$addCategoryForm.submit((e) => {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: 'postcategory',
        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
        data: $addCategoryForm.serialize(),
        success: function(res) {
            console.log('Submission was successful.');
            alert(res);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('An error occurred.');
            console.log(errorThrown);
            console.log(jqXHR);
        },
    });
});

/**
 * Request to delete category when form is submitted.
 */
$delCategoryForm.submit((e) => {
  e.preventDefault();
  $.ajax({
      type: "POST",
      url: 'delcategory',
      headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
      data: $delCategoryForm.serialize(),
      success: function(res) {
          console.log('Submission was successful.');
          alert(res);
      },
      error: function (jqXHR, textStatus, errorThrown) {
          console.log('An error occurred.');
          console.log(errorThrown);
          console.log(jqXHR);
      },
  });
});

/**
 * Open category creator form on button press.
 */
$('#categoryFormOpener').on('click', (e) => {
    $addCategoryForm.show();
    $('#categoryFormOpener').hide();
});

/**
 * Acquire dragged element in object for use in future events.
 */
var dragged;
document.addEventListener("dragstart", function(event) {
  dragged = event.target;
}, false);

/**
 * Request to switch category IDs when category dropped on another category.
 */
document.addEventListener("drop", function(event) {
  event.preventDefault();
  if(event.target.className == "drop-zone") {
    event.target.style.background = "white";
    var node = event.target.nodeName;
    var targetElement;
    if(node.localeCompare("P") === 0) targetElement = event.target.parentElement.parentElement;
    else if(node.localeCompare("DIV") == 0) targetElement = event.target.parentElement;
    var targetInnerHTML = targetElement.innerHTML, targetHREF = targetElement.href;
    targetElement.innerHTML = dragged.innerHTML;
    dragged.innerHTML = targetInnerHTML
    targetElement.href = dragged.href;
    dragged.href = targetHREF;
    $.ajax({
      type: "POST",
      url: 'categoryswitchid',
      headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
      data: {
        'draggedId': targetElement.getAttribute("categoryId"),
        'targetId': dragged.getAttribute("categoryId")
      },
      error: function (jqXHR, textStatus, errorThrown) {
          console.log('An error occurred.');
          console.log(errorThrown);
          console.log(jqXHR);
      },
    });
  }
}, false);

/**
 * Set target zone to distinguishable colour on enter.
 */
document.addEventListener("dragenter", function(event) {
  if(event.target.className == "drop-zone") {
    event.target.style.background = "gray";
  }

}, false);

/**
 * Set target zone back to original colour after leaving.
 */
document.addEventListener("dragleave", function(event) {
  if(event.target.className == "drop-zone") {
    event.target.style.background = "white";
  }

}, false);

/**
 *
 */
$('.edit-category').on('click', (e) => {
  $id = $(e.target).parent().parent().attr('categoryId');

})

/**
 * 
 */
$('.form-exit').on('click', (e) => {
  $addCategoryForm.hide();
  $('#categoryFormOpener').show();
});

/**
 * 
 */
$('.del-category').on('click', (e) => {
  e.preventDefault();
  var $h2 = $delCategoryForm.find('h2');
  console.log($h2.html());
  $h2.text($h2.text().replace("%c", $(e.target).parent().parent().attr('categoryName')));
  $delCategoryForm.show();
});