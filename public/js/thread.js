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

/***/ "./resources/js/forum/thread.js":
/*!**************************************!*\
  !*** ./resources/js/forum/thread.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var erasePostFormHTML = "<div id=\"erasePostForm\" class=\"popup-form\">\n<div class=\"form-header\">\n    <div class=\"form-exit\">\n        <i id=\"exit-icon\" class=\"fas fa-times\"></i>\n    </div>\n    <h1> Erase Post (Toggle) </h1>\n</div>\n<div class=\"form-container\">\n    <form>\n        <p> Are you sure you would like to erase/reveal this post? </p>\n        <button id=\"erasePostConfirmation\"> Confirm </button>\n    </form>\n</div>\n</div>";
var delThreadFormHTML = "<div id=\"delThreadForm\" class=\"popup-form\">\n<div class=\"form-header\">\n    <div class=\"form-exit\">\n        <i id=\"exit-icon\" class=\"fas fa-times\"></i>\n    </div>\n    <h1> Delete Thread </h1>\n</div>\n<div class=\"form-container\">\n    <form>\n        <p> Are you sure you want to delete this thread? </p>\n        <button id=\"erasePostConfirmation\"> Confirm </button>\n    </form>\n</div>\n</div>";
var lockThreadFormHTML = "<div id=\"lockThreadForm\" class=\"popup-form\">\n<div class=\"form-header\">\n    <div class=\"form-exit\">\n        <i id=\"exit-icon\" class=\"fas fa-times\"></i>\n    </div>\n    <h1> Lock Thread (Toggle) </h1>\n</div>\n<div class=\"form-container\">\n    <form>\n        <p> Are you sure you want to lock on this thread? </p>\n        <button id=\"erasePostConfirmation\"> Confirm </button>\n    </form>\n</div>\n</div>";
var $prevClickedIconPostId;
/**
 * Request to post thread reply when form is submitted
 */

$replyForm = $('#replyForm');

if ($replyForm != null) {
  var $replyInput = $replyForm.find('#replyText');
  $replyInput.on('input', function () {
    var $limit = $('meta[name="thread-length"]').attr('content');
    var $text = $replyInput.val().length;

    if ($text > $limit) {
      if ($replyForm.find('.warning').length < 1) {
        $replyForm.prepend('<p class="warning" style="color: red; text-align: center;"> Your reply is over the ' + $limit + ' character limit. </h1>');
      }
    } else {
      console.log($text + " " + $limit);

      if ($replyForm.find('.warning').length > 0) {
        $('.warning').remove();
      }
    }
  });
}

$replyForm.submit(function (e) {
  e.preventDefault();
  var $text = $replyForm.find('#replyText').val();
  var $limit = $('meta[name="thread-length"]').attr('content');
  if ($text.length > $limit) return;
  $.ajax({
    type: "POST",
    url: '/postreply',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      'text': $text,
      'thread': $('meta[name="thread"]').attr('content')
    },
    success: function success(res) {
      window.location.reload();
      console.log(res);
    },
    error: function error(xhr, ajaxOptions, thrownError) {
      console.log("Error occured during AJAX request, error code: " + xhr.status);
    }
  });
});
var $erasePostForm, $delThreadForm, $lockThreadForm;

function initForms() {
  $erasePostForm = $("#erasePostForm");
  $delThreadForm = $("#delThreadForm");
  $lockThreadForm = $('#lockThreadForm');
}

$('.erase').on('click', function (e) {
  $prevClickedIconPostId = $(e.target).attr('post');
  $("body").append(erasePostFormHTML);
  registerFormExitHandler();
  initForms();
  registerErasePostSubmitListener();
  updateColorScheme($('meta[name="color"]').attr('content'));
});
$('.del').on('click', function (e) {
  $("body").append(delThreadFormHTML);
  registerFormExitHandler();
  initForms();
  registerDelThreadSubmitListener();
  updateColorScheme($('meta[name="color"]').attr('content'));
});
$('.lock').on('click', function (e) {
  $("body").append(lockThreadFormHTML);
  registerFormExitHandler();
  initForms();
  registerLockThreadSubmitListener();
  updateColorScheme($('meta[name="color"]').attr('content'));
});
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
 * Listen for form submission
 * Request to post erase post when form is submitted.
 */

function registerErasePostSubmitListener() {
  $erasePostForm.submit(function (e) {
    e.preventDefault();
    console.log($prevClickedIconPostId);
    $.ajax({
      type: "POST",
      url: "/erasepost",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        id: $prevClickedIconPostId
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
 * Request to delete thread when form submitted.
 */


function registerDelThreadSubmitListener() {
  $delThreadForm.submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "/delthread",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        id: $('meta[name="thread"]').attr('content')
      },
      success: function success(res) {
        window.location = "/forum/category/" + $('meta[name="category"]').attr('content') + "/1";
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        console.log("Error occured during AJAX request, error code: " + xhr.status);
      }
    });
  });
}
/**
 * Listen for form submission
 * Request to delete thread when form submitted.
 */


function registerLockThreadSubmitListener() {
  $lockThreadForm.submit(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "/lockthread",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        id: $('meta[name="thread"]').attr('content')
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
 * Register click handler every time we append form to DOM.
 */


function registerFormExitHandler() {
  $(".form-exit").on("click", function (e) {
    $(".popup-form").remove();
  });
}
/**
 * Change colour to forum's color scheme on hover.
 */


$('.edit-btn, .post-edit').on('mouseover', function (e) {
  $(e.target).css({
    color: $('meta[name="color"]').attr('content'),
    transition: 'color 1s'
  });
});
$('.edit-btn, .post-edit').on('mouseout', function (e) {
  $(e.target).css({
    color: 'black',
    transition: 'color 1s'
  });
});
$('.star-symbol').on('click', function (e) {
  var $star = $(e.target);
  likePost($star, $star.attr('post'), $star.hasClass('far') ? 1 : 0);
});

function starAnim($star) {
  if ($star.hasClass('far')) {
    $star.removeClass('far');
    $star.addClass('fas');
    $star.addClass('increase-size');
    setTimeout(function () {
      $star.removeClass('increase-size');
      $star.addClass('decrease-size');
      setTimeout(function () {
        $star.removeClass('decrease-size');
      }, 250);
    }, 250);
  } else {
    $star.removeClass('fas');
    $star.addClass('far');
  }
}
/**
 * 
 * @param {int} id 
 * @param {boolean} like 
 * 
 * Make POST request to like or unlike post (like = 1 || 0)
 */


function likePost($star, id, liked) {
  $.ajax({
    type: "POST",
    url: '/likepost',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
      id: id,
      liked: liked
    },
    success: function success(res) {
      starAnim($star);
      $star.parent().find('.star-count').text(res);
    },
    error: function error(xhr, ajaxOptions, thrownError) {
      console.log("Error occured during AJAX request, error code: " + xhr.status);
    }
  });
}

updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */

function updateColorScheme(color) {
  $('#header, .popup-form, .thread-detail-wrapper').css('background', color);
}

/***/ }),

/***/ 6:
/*!********************************************!*\
  !*** multi ./resources/js/forum/thread.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xamppy\htdocs\Forumation\resources\js\forum\thread.js */"./resources/js/forum/thread.js");


/***/ })

/******/ });