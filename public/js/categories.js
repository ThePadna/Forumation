var $prevClickedEditCategoryName, $prevClickedDelCategoryName;

/**
 * Gain reference to forms and hide them in anticipation for button press.
 */
var $addCategoryForm = $('#addCategoryForm'), $delCategoryForm = $('#delCategoryForm'), $editCategoryForm = $('#editCategoryForm');
$addCategoryForm.hide();
$delCategoryForm.hide();
$editCategoryForm.hide();

/**
 * Request to post new category when form is submitted.
 */
$addCategoryForm.submit((e) => {
    e.preventDefault();
    $categoryName = $addCategoryForm.find('input[name="categoryname"]').val();
    $.ajax({
      type: "POST",
      url: 'postcategory',
      headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
      data: {'categoryName': $categoryName},
      success: function(res) {
        window.location.reload();
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
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')},
      data: {'categoryName': this.$prevClickedDelCategoryName},
      success: function(res) {
        window.location.reload();
        console.log(res);
      },
      error: function (jqXHR, textStatus, errorThrown) {
          console.log('An error occurred.');
          console.log(errorThrown);
          console.log(jqXHR);
      },
  });
});

/**
 * Request to edit category when form is submitted.
 */
$editCategoryForm.submit((e) => {
  e.preventDefault();
  $categoryName = $editCategoryForm.find('input[name="categoryname"]').val();
  console.log("null?" + this.$prevClickedEditCategoryName);
  $.ajax({
      type: "POST",
      url: 'editcategory',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')},
      data: {'categoryName': this.$prevClickedEditCategoryName, 'newCategoryName': $categoryName},
      success: function(res) {
        window.location.reload();
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
    event.target.style.background = "black";
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
 * Hide form instance and show hidden button(s).
 */
$('.form-exit').on('click', (e) => {
  $('.popup-form').hide();
  $('#categoryFormOpener').show();
});

/**
 * Set file scope var for use in ajax request.
 * Replace placeholder value with clicked category name.
 */
$('.del-category').on('click', (e) => {
  e.preventDefault();
  this.$prevClickedDelCategoryName = $(e.target).parent().parent().attr('categoryName');
  var $h2 = $delCategoryForm.find('h2');
  $h2.text($h2.text().replace("%c", this.$prevClickedDelCategoryName));
  $delCategoryForm.show();
});

/**
 * Fill form's input with old category ready to edit.
 */
$('.edit-category').on('click', (e) => {
  e.preventDefault();
  this.$prevClickedEditCategoryName = $(e.target).parent().parent().attr('categoryName');
  $editCategoryForm.find('input').val(this.$prevClickedEditCategoryName);
  $editCategoryForm.show();
});