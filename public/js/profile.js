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
/******/ 	return __webpack_require__(__webpack_require__.s = 11);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/forum/profile.js":
/*!***************************************!*\
  !*** ./resources/js/forum/profile.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var banUserFormHTML = "<div id=\"banUserForm\" class=\"popup-form\">\n<div class=\"form-header\">\n    <div class=\"form-exit\">\n        <i id=\"exit-icon\" class=\"fas fa-times\"></i>\n    </div>\n    <h1> Ban User </h1>\n</div>\n<div class=\"form-container\">\n    <form>\n        <input id=\"cause\" type=\"text\" name=\"cause\" placeholder=\"Cause\" />\n        <button id=\"confirmBan\"> Confirm Ban </button>\n    </form>\n</div>\n</div>";
updateColorScheme($('meta[name="color"]').attr('content'));
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
displayStats();
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */

function updateColorScheme(color) {
  $('#header, .popup-form').css('background', color);
  $('p').css('color', color);
}
/**
 * Initialize forms that are used when a 'popup-form' is needed.
 */


var $banUserForm;

function initForms() {
  $banUserForm = $("#banUserForm");
}
/**
 * Listen for form submission
 * Request to post new category when form is submitted.
 */


function registerBanUserSubmitListener() {
  $banUserForm.submit(function (e) {
    e.preventDefault();
    var $cause = $banUserForm.find('input[name="cause"]').val();
    $.ajax({
      type: "POST",
      url: "/banuser",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content")
      },
      data: {
        user: $('meta[name="user"]').attr("content"),
        cause: $cause
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
 * Open user ban form on click.
 */


$("#ban-btn").on("click", function (e) {
  $("body").append(banUserFormHTML);
  registerFormExitHandler();
  initForms();
  registerBanUserSubmitListener();
  updateColorScheme($('meta[name="color"]').attr('content'));
});
/**
 * Load all Posts, Threads, and Scores for user
 * Increment them to retrieved value as a displaying animation
 */

function displayStats() {
  var posts = $('meta[name="posts"]').attr('content'),
      threads = $('meta[name="threads"]').attr('content'),
      score = $('meta[name="score"]').attr('content');
  var $posts = $('#posts-counter'),
      $threads = $('#threads-counter'),
      $score = $('#score-counter');
  animateCounting($posts, posts);
  animateCounting($threads, threads);
  animateCounting($score, score);
}

function animateCounting($obj, count) {
  console.log(count);

  if (count == 0) {
    $obj.text(count);
    return;
  }

  $({
    count: 0
  }).animate({
    count: count - count / 5
  }, {
    duration: 500,
    easing: 'linear',
    step: function step() {
      $obj.text(Math.round(this.count));
    },
    complete: function complete() {
      $({
        count: $obj.text()
      }).animate({
        count: count
      }, {
        duration: 650,
        easing: 'linear',
        step: function step() {
          $obj.text(Math.round(this.count));
        }
      });
    }
  });
}

/***/ }),

/***/ 11:
/*!******************************************!*\
  !*** multi ./resources/js/forum/profile ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xamppy\htdocs\Forumation\resources\js\forum\profile */"./resources/js/forum/profile.js");


/***/ })

/******/ });