var $prevClickedEditCategoryName, $prevClickedDelCategoryName;

var addCategoryFormHTML = `<div id="addCategoryForm" class="popup-form">
<div class="form-header">
    <div class="form-exit">
        <i id="exit-icon" class="fas fa-times"></i>
    </div>
    <h1> New Category </h1>
</div>
<div class="form-container">
    <form>
        <input id="categoryTitle" type="text" name="categoryTitle" />
        <button id="categoryFormCloser"> Add Category </button>
    </form>
</div>
</div>`;
var editCategoryFormHTML = `<div id="editCategoryForm" class="popup-form">
<div class="form-header">
    <div class="form-exit">
        <i id="exit-icon" class="fas fa-times"></i>
    </div>
    <h1> Edit Category </h1>
</div>
<div class="form-container">
    <form>
        <input type="text" name="categoryname" />
        <button id="categoryFormCloser"> Confirm Edit </button>
    </form>
</div>
</div>`;
var delCategoryFormHTML = `<div id="delCategoryForm" class="popup-form">
<div class="form-header">
    <div class="form-exit">
        <i id="exit-icon" class="fas fa-times"></i>
    </div>
    <h1> Delete Category </h1>
</div>
<div class="form-container">
    <form>
        <h2> Delete Category '%c'? </h2>
        <button id="categoryFormCloser"> Confirm Deletion </button>
    </form>
</div>
</div>`;

/**
 * Gain reference to forms and hide them in anticipation for button press.
 * Initialize them with #initForms before submission
 */
var $addCategoryForm,
    $delCategoryForm,
    $editCategoryForm;
function initForms() {
    $addCategoryForm = $('#addCategoryForm');
    $delCategoryForm = $('#delCategoryForm');
    $editCategoryForm = $('#editCategoryForm');
}
/**
 * Listen for form submission
 * Request to post new category when form is submitted.
 */
function registerAddFormSubmitListener() {
    $addCategoryForm.submit(e => {
        console.log("umit");
        e.preventDefault();
        $title = $addCategoryForm.find('input[name="categoryTitle"]').val();
        $addCategoryForm.find('input[name="categoryTitle"]').val("");
        $.ajax({
            type: "POST",
            url: "/postcategory",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
            data: { categoryTitle: $title },
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
 * Listen for form submission
 * Request to delete category when form is submitted.
 */
function registerDelFormSubmitListener() {
    $delCategoryForm.submit(e => {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/delcategory",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
            data: { categoryName: this.$prevClickedDelCategoryName },
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
 * Listen for form submission
 * Request to edit category when form is submitted.
 */
function registerEditFormSubmitListener() {
    $editCategoryForm.submit(e => {
        e.preventDefault();
        $categoryName = $editCategoryForm
            .find('input[name="categoryname"]')
            .val();
        $.ajax({
            type: "POST",
            url: "/editcategory",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
            data: {
                categoryName: this.$prevClickedEditCategoryName,
                newCategoryName: $categoryName
            },
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
 * Open category creator form on button press.
 */
$("#categoryFormOpener").on("click", e => {
    $("#categories").append(addCategoryFormHTML);
    this.registerFormExitHandler();
    this.initForms();
    this.registerAddFormSubmitListener();
});

/**
 * Acquire dragged element in object for use in future events.
 */
var dragged;
document.addEventListener(
    "dragstart",
    function(event) {
        dragged = event.target;
    },
    false
);

/**
 * Request to switch category IDs when category dropped on another category.
 */
document.addEventListener(
    "drop",
    function(event) {
        event.preventDefault();
        if (event.target.className == "drop-zone") {
            event.target.style.background = "white";
            var node = event.target.nodeName;
            var targetElement;
            if (node.localeCompare("P") === 0)
                targetElement = event.target.parentElement.parentElement;
            else if (node.localeCompare("DIV") == 0)
                targetElement = event.target.parentElement;
            var targetInnerHTML = targetElement.innerHTML,
                targetHREF = targetElement.href;
            targetElement.innerHTML = dragged.innerHTML;
            dragged.innerHTML = targetInnerHTML;
            targetElement.href = dragged.href;
            dragged.href = targetHREF;
            $.ajax({
                type: "POST",
                url: "/categoryswitchid",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content")
                },
                data: {
                    draggedId: targetElement.getAttribute("categoryId"),
                    targetId: dragged.getAttribute("categoryId")
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(
                        "Error occured during AJAX request, error code: " +
                            xhr.status
                    );
                }
            });
        }
    },
    false
);

/**
 * Set target zone to distinguishable colour on enter.
 */
document.addEventListener(
    "dragenter",
    function(event) {
        if (event.target.className == "drop-zone") {
            event.target.style.background = "black";
        }
    },
    false
);

/**
 * Set target zone back to original colour after leaving.
 */
document.addEventListener(
    "dragleave",
    function(event) {
        if (event.target.className == "drop-zone") {
            event.target.style.background = "white";
        }
    },
    false
);

/**
 * Register click handler every time we append form to DOM.
 */
function registerFormExitHandler() {
    $(".form-exit").on("click", e => {
        $(".popup-form").remove();
    });
}
/**
 * Set file scope var for use in ajax request.
 * Replace placeholder value with clicked category name.
 */
$(".del-category").on("click", e => {
    e.preventDefault();
    this.$prevClickedDelCategoryName = $(e.target)
        .parent()
        .children()[0].innerHTML;
    $("#categories").append(
        delCategoryFormHTML.replace(
            "%c",
            this.$prevClickedDelCategoryName.trim()
        )
    );
    this.registerFormExitHandler();
    this.initForms();
    this.registerDelFormSubmitListener();
});

/**
 * Fill form's input with old category ready to edit.
 */
$(".edit-category").on("click", e => {
    e.preventDefault();
    this.$prevClickedDelCategoryName = $(e.target)
        .parent()
        .children()[0].innerHTML;
    $("#categories").append(
        editCategoryFormHTML.replace(
            "%c",
            this.$prevClickedDelCategoryName.trim()
        )
    );
    this.registerFormExitHandler();
    this.initForms();
    this.registerEditFormSubmitListener();
});
