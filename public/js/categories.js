var $form = $('#addCategoryForm');
$form.hide();
$form.submit((e) => {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: 'postcategory',
        headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
        data: $form.serialize(),
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
var $categoryFormOpener = $('#categoryFormOpener').click(() => {
    $form.show();
    $categoryFormOpener.hide();
});
var dragged;
document.addEventListener("dragstart", function(event) {
  dragged = event.target;
}, false);
document.addEventListener("drop", function(event) {
  event.preventDefault();
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
  console.log("Dragged: " + dragged.getAttribute("categoryId") + " target: " + targetElement.getAttribute("categoryId"));
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
}, false);
document.addEventListener("dragover", function(event) {
  event.preventDefault();
}, false);
document.addEventListener("dragenter", function(event) {
  if (event.target.className == "drop-zone") {
    event.target.style.background = "gray";
  }

}, false);
document.addEventListener("dragleave", function(event) {
  if (event.target.className == "drop-zone") {
    event.target.style.background = "white";
  }

}, false);