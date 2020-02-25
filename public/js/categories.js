/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/categories.js":
/*!************************************!*\
  !*** ./resources/js/categories.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var $prevClickedEditCategoryDesc, $prevClickedDelCategoryName, $prevClickedDelCategoryId;
var addCategoryFormHTML = "<div id=\"addCategoryForm\" class=\"popup-form\">\n<div class=\"form-header\">\n    <div class=\"form-exit\">\n        <i id=\"exit-icon\" class=\"fas fa-times\"></i>\n    </div>\n    <h1> New Category </h1>\n</div>\n<div class=\"form-container\">\n    <form>\n        <input id=\"categoryTitle\" type=\"text\" name=\"categoryTitle\" placeholder=\"Category Name\">\n        <input id=\"categoryDesc\" type=\"text\" name=\"categoryDesc\" placeholder=\"Description\" />\n        <button id=\"categoryFormCloser\"> Add Category </button>\n    </form>\n</div>\n</div>";
var editCategoryFormHTML = "<div id=\"editCategoryForm\" class=\"popup-form\">\n<div class=\"form-header\">\n    <div class=\"form-exit\">\n        <i id=\"exit-icon\" class=\"fas fa-times\"></i>\n    </div>\n    <h1> Edit Category </h1>\n</div>\n<div class=\"form-container\">\n    <form>\n        <input type=\"text\" name=\"categoryname\" value=\"%c\" />\n        <input type=\"text\" name=\"description\" value=\"%d\" />\n        <button id=\"categoryFormCloser\"> Confirm Edit </button>\n    </form>\n</div>\n</div>";
var delCategoryFormHTML = "<div id=\"delCategoryForm\" class=\"popup-form\">\n<div class=\"form-header\">\n    <div class=\"form-exit\">\n        <i id=\"exit-icon\" class=\"fas fa-times\"></i>\n    </div>\n    <h1> Delete Category </h1>\n</div>\n<div class=\"form-container\">\n    <form>\n        <h2> Delete Category '%c'? </h2>\n        <button id=\"categoryFormCloser\"> Confirm Deletion </button>\n    </form>\n</div>\n</div>";
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
 * Change colour to forum's color scheme on hover.
 */


$('.edit-btn, .switch-btn').on('mouseover', function (e) {
  $(e.target).css({
    color: $('meta[name="color"]').attr('content'),
    transition: 'color 1s'
  });
});
$('.edit-btn, .switch-btn').on('mouseout', function (e) {
  $(e.target).css({
    color: 'black',
    transition: 'color 1s'
  });
});
/**
 * Listen for form submission
 * Request to post new category when form is submitted.
 */

function registerAddFormSubmitListener() {
  $addCategoryForm.submit(function (e) {
    e.preventDefault();
    $title = $addCategoryForm.find('input[name="categoryTitle"]').val();
    $desc = $addCategoryForm.find('input[name="categoryDesc"]').val();
    $.ajax({
      type: "POST",
      url: "/postcategory",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content")
      },
      data: {
        categoryTitle: $title,
        categoryDesc: $desc
      },
      success: function success(res) {
        window.location.reload();
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        console.log("Error occured during AJAX request, error code: " + xhr.status);
      }
    });
  });
}
/**
 * Listen for form submission
 * Request to delete category when form is submitted.
 */


function registerDelFormSubmitListener() {
  $delCategoryForm.submit(function (e) {
    e.preventDefault();
    console.log($prevClickedDelCategoryId);
    $.ajax({
      type: "POST",
      url: "/delcategory",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content")
      },
      data: {
        id: $prevClickedDelCategoryId
      },
      success: function success(res) {
        window.location.reload();
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        console.log("Error occured during AJAX request, error code: " + xhr.status);
      }
    });
  });
}
/**
 * Listen for form submission
 * Request to edit category when form is submitted.
 */


function registerEditFormSubmitListener() {
  $editCategoryForm.submit(function (e) {
    e.preventDefault();
    $categoryName = $editCategoryForm.find('input[name="categoryname"]').val();
    $description = $editCategoryForm.find('input[name="description"]').val();
    $.ajax({
      type: "POST",
      url: "/editcategory",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content")
      },
      data: {
        id: $prevClickedDelCategoryId,
        description: $description,
        newCategoryName: $categoryName
      },
      success: function success(res) {
        window.location.reload();
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        console.log("Error occured during AJAX request, error code: " + xhr.status);
      }
    });
  });
}
/**
 * Open category creator form on button press.
 */


$("#categoryFormOpener").on("click", function (e) {
  $("#categories").append(addCategoryFormHTML);
  registerFormExitHandler();
  initForms();
  registerAddFormSubmitListener();
  updateColorScheme($('meta[name="color"]').attr('content'));
  exitFormBtnHoverColorListener($('meta[name="color"]').attr('content'));
});
/**
 * Register click handler every time we append form to DOM.
 */

function registerFormExitHandler() {
  $(".form-exit").on("click", function (e) {
    $(".popup-form").remove();
  });
}
/**
 * Listen for switch buttons.
 * Replace categoryId of adjacent elements to load the page with a different order.
 */


$('.up-arrow').on('click', function (e) {
  e.preventDefault();
  var clickedId = $(e.target).attr('categoryId');
  var switchWith = getAdjacentCategory(clickedId, true);

  if (typeof switchWith !== 'undefined') {
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
      success: function success(res) {
        window.location.reload();
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        console.log("Error occured during AJAX request, error code: " + xhr.status);
      }
    });
  }
});
/**
 * Listen for switch buttons.
 * Replace categoryId of adjacent elements to load the page with a different order.
 */

$('.down-arrow').on('click', function (e) {
  e.preventDefault();
  var clickedId = $(e.target).attr('categoryId');
  var switchWith = getAdjacentCategory(clickedId, false);

  if (typeof switchWith !== 'undefined') {
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
      success: function success(res) {
        window.location.reload();
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        console.log("Error occured during AJAX request, error code: " + xhr.status);
      }
    });
  }
});
/**
 * Get adjacent category of category's id.
 * above var is the decider of which direction to search.
 * 
 * @param {int} id 
 * @param {boolean} above 
 */

function getAdjacentCategory(id, above) {
  var lastIterId = null;
  var $catArray = $('a');

  for (var i = 0; i < $catArray.length; i++) {
    var eid = $catArray[i].getAttribute('categoryid');
    console.log("eid" + eid);

    if (lastIterId != null && id == eid && above) {
      console.log("Returning " + lastIterId);
      return lastIterId;
    }

    if (lastIterId != null && !above && lastIterId == id) {
      return eid;
    }

    lastIterId = $catArray[i].getAttribute('categoryid');
  }
}
/**
 * Set file scope var for use in ajax request.
 * Replace placeholder value with clicked category name.
 */


$(".del-category").on("click", function (e) {
  e.preventDefault();
  $prevClickedDelCategoryName = $(e.target).attr('categoryName');
  $prevClickedDelCategoryId = $(e.target).attr('categoryId');
  $("#categories").append(delCategoryFormHTML.replace("%c", $prevClickedDelCategoryName.trim()));
  registerFormExitHandler();
  initForms();
  registerDelFormSubmitListener();
  updateColorScheme($('meta[name="color"]').attr('content'));
  exitFormBtnHoverColorListener($('meta[name="color"]').attr('content'));
});
/**
 * Fill form's input with old category ready to edit.
 */

$(".edit-category").on("click", function (e) {
  e.preventDefault();
  $prevClickedDelCategoryName = $(e.target).attr('categoryName');
  $prevClickedEditCategoryDesc = $(e.target).attr('categoryDesc');
  $prevClickedDelCategoryId = $(e.target).attr('categoryId');
  $("#categories").append(editCategoryFormHTML.replace("%c", $prevClickedDelCategoryName.trim()).replace("%d", $prevClickedEditCategoryDesc.trim()));
  registerFormExitHandler();
  initForms();
  registerEditFormSubmitListener();
  updateColorScheme($('meta[name="color"]').attr('content'));
  exitFormBtnHoverColorListener($('meta[name="color"]').attr('content'));
});
updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */

function updateColorScheme(color) {
  $('#header, .popup-form').css('background', color);
}

$(document).on('mouseover', '.form-exit', function (e) {
  $(e.target).css({
    color: 'red',
    transition: 'color 1s'
  });
});
$(document).on('mouseout', '.form-exit', function (e) {
  $(e.target).css({
    color: 'gray',
    transition: 'color 1s'
  });
});
if ($('meta[name="editor-mode"]').attr('content') == 0) removeEditorElements();

function removeEditorElements() {
  var EDITOR_ELEMENTS = [$('.del-category'), $('.edit-category'), $('.switch-btn')];
  EDITOR_ELEMENTS.forEach(function ($e) {
    $e.remove();
  });
}

/***/ }),

/***/ 1:
/*!******************************************!*\
  !*** multi ./resources/js/categories.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xamppy\htdocs\Forumation\resources\js\categories.js */"./resources/js/categories.js");


/***/ })

/******/ });