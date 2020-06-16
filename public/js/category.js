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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/forum/category.js":
/*!****************************************!*\
  !*** ./resources/js/forum/category.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var delThreadFormHTML = "<div id=\"delThreadForm\" class=\"popup-form\">\n<div class=\"form-header\">\n    <div class=\"form-exit\">\n        <i id=\"exit-icon\" class=\"fas fa-times\"></i>\n    </div>\n    <h1> Delete Thread </h1>\n</div>\n<div class=\"form-container\">\n    <form>\n        <h2> Delete Thread '%t'? </h2>\n        <button id=\"categoryFormCloser\"> Confirm Deletion </button>\n    </form>\n</div>\n</div>";
var $prevClickedDelThreadName, $prevClickedDelThreadId;
updateColorScheme($('meta[name="color"]').attr('content'));
$('#post-thread-input').on('click', function (e) {
  console.log("ho");
  window.location = "/forum/category/" + $('meta[name="category"]').attr('content') + "/post";
});
/**
 * Initialize forms that are used when a 'popup-form' is needed.
 */

var $delThreadForm;

function initForms() {
  $delThreadForm = $("#delThreadForm");
}
/**
 * Listen for form submission
 * Request to delete category when form is submitted.
 */


function registerDelFormSubmitListener() {
  $delThreadForm.submit(function (e) {
    e.preventDefault();
    console.log("sbit");
    $.ajax({
      type: "POST",
      url: "/delthread",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content")
      },
      data: {
        id: $prevClickedDelThreadId.trim()
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

$(".del-thread").on("click", function (e) {
  e.preventDefault();
  $prevClickedDelThreadId = $(e.target).attr('threadId');
  $prevClickedDelThreadName = $(e.target).attr('threadName');
  $("#threads").append(delThreadFormHTML.replace("%t", $prevClickedDelThreadName.trim()));
  registerFormExitHandler();
  initForms();
  registerDelFormSubmitListener();
  updateColorScheme($('meta[name="color"]').attr('content'));
});
/**
 * Register click handler every time we append form to DOM.
 */

function registerFormExitHandler() {
  $(".form-exit").on("click", function (e) {
    $(".popup-form").remove();
  });
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
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */

function updateColorScheme(color) {
  $('#header, .popup-form').css('background', color);
  $('#prevpage, #nextpage, #postThread>*').css('color', color);
}

if ($('meta[name="editor-mode"]').attr('content') == 0) removeEditorElements();

function removeEditorElements() {
  var EDITOR_ELEMENTS = [$('.del-thread')];
  EDITOR_ELEMENTS.forEach(function ($e) {
    $e.remove();
  });
}

/***/ }),

/***/ 6:
/*!**********************************************!*\
  !*** multi ./resources/js/forum/category.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xamppy\htdocs\Forumation\resources\js\forum\category.js */"./resources/js/forum/category.js");


/***/ })

/******/ });