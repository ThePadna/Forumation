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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/forum/forum_layout.js":
/*!********************************************!*\
  !*** ./resources/js/forum/forum_layout.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Hide messaging popup contents and set unread message notification value.
 */
$('.message-popup').hide();
$('.scroll-up').hide();
$('.notifications').text($('meta[name="unread"]').attr('content'));
/**
 * Listen for conversation click, replace conversation list with new messages list
 */

$('.conversation').on('click', function (e) {
  $('.conversation').hide();
  var $u1 = $(e.target.parentElement).attr('user-1'),
      $u2 = $(e.target.parentElement).attr('user-2');
  var $userImage = $(e.target.parentElement).find('img').attr('src');
  var yourImage = $('meta[name="avatar"]').attr('content');
  var yourName = $('meta[name="username"]').attr('content');
  $.ajax({
    type: "POST",
    url: "/queryconversation",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    data: {
      user1: $u1,
      user2: $u2
    },
    success: function success(res) {
      $('.message-popup').append('<div class="return-btn"> <i class="fas fa-long-arrow-alt-left"></i> </div>');
      registerReturnListener();
      var messages = res.split(",");
      messages.forEach(function (e) {
        var info = e.split(":");
        var sentBy = info[0].localeCompare(yourName) == 0 ? "you" : "user";
        var imageToUse = sentBy.localeCompare("you") == 0 ? yourImage : $userImage;
        $('.message-popup').append("<div class=\"message " + sentBy + "\"> <div class=\"avatar\"> <img src=\"" + imageToUse + "\" /> </div> <div class=\"content\"> <p> " + info[1] + " </p> </div> </div>");
      });
    },
    error: function error(xhr, ajaxOptions, thrownError) {
      console.log("Error occured during AJAX request, error code: " + xhr.status);
    }
  });
});
/**
 * Register listeners for exiting the message popup.
 */

function registerReturnListener() {
  $('.return-btn').on('click', function () {
    $('.message').remove();
    $('.return-btn').remove();
    $('.conversation').show();
  });
}
/**
 * Slide the message popup up or down depending on dir's value (down = true, up = false).
 * @param {boolean} dir 
 */


function slide(dir) {
  if (dir) {
    $('.message-popup').slideDown(250, function () {
      $('.scroll-up').show();
    });
  } else {
    $('.scroll-up').hide();
    $('.message-popup').slideUp(250);
  }
}
/**
 * Listen for message popup buttons.
 */


$('.inbox, .scroll-up').on('click', function () {
  if ($('.message-popup').is(':hidden')) slide(true);else slide(false);
});

/***/ }),

/***/ 2:
/*!**************************************************!*\
  !*** multi ./resources/js/forum/forum_layout.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xamppy\htdocs\Forumation\resources\js\forum\forum_layout.js */"./resources/js/forum/forum_layout.js");


/***/ })

/******/ });