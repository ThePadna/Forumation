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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/thread.js":
/*!********************************!*\
  !*** ./resources/js/thread.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Request to post thread reply when form is submitted
 */
$replyForm = $('#replyForm');
$replyForm.submit(function (e) {
  e.preventDefault();
  $text = $replyForm.find('#replyText').val();
  $.ajax({
    type: "POST",
    url: '/postreply',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')
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
      'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')
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
  $('#header').css('background', color);
  $('.star-symbol, .star-count').css('color', color);
}

/***/ }),

/***/ 4:
/*!**************************************!*\
  !*** multi ./resources/js/thread.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xamppy\htdocs\Forumation\resources\js\thread.js */"./resources/js/thread.js");


/***/ })

/******/ });