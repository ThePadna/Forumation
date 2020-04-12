import '@simonwep/pickr/dist/themes/nano.min.css';
import Pickr from '@simonwep/pickr';
$(".dropdown-menu p").click((e) => {
    e.stopPropagation();
    let $ele = $(e.target);
    $ele.toggleClass('selected');
    $ele.toggleClass('unselected')
})
$(".dropdown-menu p").mouseover(e => {
    let $ele = $(e.target);
    let prefix = $ele.hasClass('selected') ? "-" : "+";
    $ele.text(prefix + $ele.text());
    $ele.css('background', 'white');
});
$(".dropdown-menu p").mouseout(e => {
    let $ele = $(e.target);
    $ele.text($ele.text().replace(new RegExp("[-+]"), ""));
});
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}
$('.color').each(function(i, obj) {
    let $id = $(obj).attr('id');
    let $HEXcolor = $(obj).css('color');
    let pickr = Pickr.create({
        el: '#' + $id,
        theme: 'nano', // or 'monolith', or 'nano'
    
        swatches: [
            'rgba(244, 67, 54, 1)',
            'rgba(233, 30, 99, 0.95)',
            'rgba(156, 39, 176, 0.9)',
            'rgba(103, 58, 183, 0.85)',
            'rgba(63, 81, 181, 0.8)',
            'rgba(33, 150, 243, 0.75)',
            'rgba(3, 169, 244, 0.7)',
            'rgba(0, 188, 212, 0.7)',
            'rgba(0, 150, 136, 0.75)',
            'rgba(76, 175, 80, 0.8)',
            'rgba(139, 195, 74, 0.85)',
            'rgba(205, 220, 57, 0.9)',
            'rgba(255, 235, 59, 0.95)',
            'rgba(255, 193, 7, 1)'
        ],
    
        components: {
    
            // Main components
            preview: true,
            opacity: true,
            hue: true,
    
            // Input / output Options
            interaction: {
                hex: true,
                rgba: true,
                hsla: true,
                hsva: true,
                cmyk: true,
                input: true,
                clear: true,
                save: true
            }
        }
    });
    setTimeout(function() {
        pickr.setColor($HEXcolor);
    }, 25);
});
$('.save').on('click', e => {
    let $ranksJson = [];
    $('.rank').each((i, e) => {
        let $name = $(e).find('.name').val();
        let $color = $(e).find('.pcr-button').css('color').replace(/\s/g, '');
        let $stopIndex = ($color.length - 5); //No idea what's happening here..
        let $rgb = $color.trim().substr(4, $stopIndex);
        let $split = $rgb.split(',');
        let $r = $split[0], $g = $split[1], $b = $split[2];
        $color = rgbToHex($r, $g, $b);
        let permsArray = [];
        $(e).find('.selected').each((i, e) => {
            permsArray[i] = ($(e).text().trim());
        });
        let $jsonObj = {
            "name": $name,
            "color": $color,
            "perms": permsArray
        }
        $ranksJson.push($jsonObj);
    });
    console.log($ranksJson);
    $.ajax({
        type: "POST",
        url: '/updateranks',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
        data: {"ranks" : JSON.stringify($ranksJson)},
        success: function(res) {
            console.log(res);
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log("Error occured during AJAX request, error code: " + xhr.status);
        },
    });
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

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}
  
function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}
