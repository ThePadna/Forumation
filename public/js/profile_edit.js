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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/forum/profile_edit.js":
/*!********************************************!*\
  !*** ./resources/js/forum/profile_edit.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var $usernameInp = $('#usernameInput');
var $picInp = $('#profilepic');
updateColorScheme($('meta[name="color"]').attr('content'));
$usernameInp = $('#username-input');

if ($usernameInp != null) {
  $usernameInp.on('input', function () {
    var $limit = $('meta[name="username-length"]').attr('content');
    var $text = $usernameInp.val().length;

    if ($text > $limit) {
      if ($('.warning').length < 1) {
        $('.error-container').append('<p class="warning" style="color: red; text-align: center;"> Your username is over the ' + $limit + ' character limit. This will not be updated. </h1>');
      }
    } else {
      console.log($text + " " + $limit);

      if ($('.warning').length > 0) {
        $('.warning').remove();
      }
    }
  });
}

$('form').submit(function (e) {
  e.preventDefault();
  var formData = new FormData();
  var $name = $usernameInp.val();
  var $rank = $('.selected-rank').attr('rankId');
  console.log("name;" + $name);
  if ($name != null) formData.append("username", $name);
  var $src = $picInp.attr('src');
  if ($src != null) formData.append("pic", $src);
  if ($rank != -1) formData.append("rank", $rank);
  $.ajax({
    type: "POST",
    url: '/forum/profile/' + $('meta[name="userId"]').attr('content') + '/edit/updateprofile',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf"]').attr('content')
    },
    data: formData,
    processData: false,
    contentType: false,
    success: function success(res) {
      window.location = "/forum/profile/" + res;
    },
    error: function error(xhr, ajaxOptions, thrownError) {
      console.log("Error occured during AJAX request, error code: " + xhr.status);
    }
  });
});
$('#pic').change(function (e) {
  var reader = new FileReader();

  reader.onload = function (e) {
    $('#profilepic').attr('src', e.target.result);
  };

  reader.readAsDataURL(e.target.files[0]);
});
$('.dropdown-item').on('click', function (e) {
  var $rId = $(e.target).attr('id');
  var $rName = $(e.target).text();
  $('.selected-rank').attr('rankId', $rId);
  $('.selected-rank').text($rName);
});
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */

function updateColorScheme(color) {
  $('#header').css('background', color);
}

/***/ }),

/***/ 3:
/*!**************************************************!*\
  !*** multi ./resources/js/forum/profile_edit.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xamppy\htdocs\Forumation\resources\js\forum\profile_edit.js */"./resources/js/forum/profile_edit.js");


/***/ })

/******/ });