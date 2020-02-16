var $prevClickedEditCategoryDesc, $prevClickedDelCategoryName;

var addCategoryFormHTML = `<div id="addCategoryForm" class="popup-form">
<div class="form-header">
    <div class="form-exit">
        <i id="exit-icon" class="fas fa-times"></i>
    </div>
    <h1> New Category </h1>
</div>
<div class="form-container">
    <form>
        <input id="categoryTitle" type="text" name="categoryTitle" placeholder="Category Name">
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
        <input type="text" name="categoryname" value="%c" />
        <input type="text" name="description" value="%d" />
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
            data: { categoryName: $prevClickedDelCategoryName },
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
        $description = $editCategoryForm
            .find('input[name="description"]')
            .val();
            console.log("catName:" + $prevClickedDelCategoryName);
        $.ajax({
            type: "POST",
            url: "/editcategory",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
            data: {
                categoryName: $prevClickedDelCategoryName,
                description: $description,
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
    registerFormExitHandler();
    initForms();
    registerAddFormSubmitListener();
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
 * Listen for switch buttons.
 * Replace categoryId of adjacent elements to load the page with a different order.
 */
$('.up-arrow').on('click', e => {
    e.preventDefault();
    let clickedId = $(e.target).parent().parent().parent().attr('categoryid');
    let switchWith = getAdjacentCategory(clickedId, true);
    if(typeof switchWith !== 'undefined') {
        $.ajax({
            type: "POST",
            url: "/categoryswitchid",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content")
            },
            data: {
                draggedId: clickedId,
                targetId: switchWith
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
    }
});
$('.down-arrow').on('click', e => {
    e.preventDefault();
    let clickedId = $(e.target).parent().parent().parent().attr('categoryid');
    let switchWith = getAdjacentCategory(clickedId, false);
    if(typeof switchWith !== 'undefined') {
        $.ajax({
            type: "POST",
            url: "/categoryswitchid",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content")
            },
            data: {
                draggedId: clickedId,
                targetId: switchWith
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
    }
});
function getAdjacentCategory(id, above) {
    let lastIterId = null;
    let $catArray = $('a');
    for(let i = 0; i < $catArray.length; i++) {
        let eid = $catArray[i].getAttribute('categoryid');
        console.log("eid" + eid);
        if(lastIterId != null && id == eid && above) {
            console.log("Returning " + lastIterId);
            return lastIterId;
        }
        if(lastIterId != null && !above && lastIterId == id) {
            return eid;
        }
        lastIterId = $catArray[i].getAttribute('categoryid');
    }
}
/**
 * Set file scope var for use in ajax request.
 * Replace placeholder value with clicked category name.
 */
$(".del-category").on("click", e => {
    e.preventDefault();
    $prevClickedDelCategoryName = $(e.target)
        .parent()
        .parent()
        .find('#name')
        .text();
    $("#categories").append(
        delCategoryFormHTML.replace(
            "%c",
            $prevClickedDelCategoryName.trim()
        )
    );
    registerFormExitHandler();
    initForms();
    registerDelFormSubmitListener();
});

/**
 * Fill form's input with old category ready to edit.
 */
$(".edit-category").on("click", e => {
    e.preventDefault();
    $prevClickedDelCategoryName = $(e.target)
    .parent()
    .parent()
    .find('#name')
    .text();
    $prevClickedEditCategoryDesc = $(e.target)
    .parent()
    .parent()
    .find('#desc')
    .text();
    console.log($prevClickedDelCategoryName);
    $("#categories").append(
        editCategoryFormHTML.replace(
            "%c",
            $prevClickedDelCategoryName.trim()
        ).replace( 
            "%d",
            $prevClickedEditCategoryDesc.trim()
        )
    );
    registerFormExitHandler();
    initForms();
    registerEditFormSubmitListener();
});
updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
}
if($('meta[name="editor-mode"]').attr('content') == 0) removeEditorElements();
function removeEditorElements() {
    let EDITOR_ELEMENTS = [$('.del-category'), $('.edit-category'), $('.switch-btn')];
    EDITOR_ELEMENTS.forEach($e => {
        $e.remove();
    });
}
