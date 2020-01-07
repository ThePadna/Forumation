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
        <input id="categoryTitle" type="text" name="categoryTitle" placeholder="Category Name" />
        <input id="categoryDesc" type="text" name="categoryDesc" placeholder="Description" />
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
var $addCategoryForm, $delCategoryForm, $editCategoryForm;
function initForms() {
    $addCategoryForm = $("#addCategoryForm");
    $delCategoryForm = $("#delCategoryForm");
    $editCategoryForm = $("#editCategoryForm");
}
$("[data-link]").click(function() {
    window.location.href = $(this).attr("data-link");
    return false;
});
/**
 * Listen for form submission
 * Request to post new category when form is submitted.
 */
function registerAddFormSubmitListener() {
    $addCategoryForm.submit(e => {
        e.preventDefault();
        $title = $addCategoryForm.find('input[name="categoryTitle"]').val();
        $desc = $addCategoryForm.find('input[name="categoryDesc"]').val();
        $.ajax({
            type: "POST",
            url: "/postcategory",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
            data: { categoryTitle: $title, categoryDesc: $desc },
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
 * Request to switch category IDs when category dropped on another category.
 */
$(".drop-zone").bind("drop", function() {
    console.log("dropping");
    $dragging = false;
    $target = $(this);
    $.ajax({
        type: "POST",
        url: "/categoryswitchid",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content")
        },
        data: {
            draggedId: $target.attr("categoryId"),
            targetId: $dragged.attr("categoryId")
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
/**
 * Change colour of target element when dragging over with other element.
 */
$(".drop-zone").bind("dragover", function() {
    $(this).css("background", "red");
});

/**
 * Reset colour of target element when exiting with drag.
 */
$(".drop-zone").bind("dragleave", function() {
    $(this).css("background", "white");
});

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
