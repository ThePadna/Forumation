import '@simonwep/pickr/dist/themes/nano.min.css';
import Pickr from '@simonwep/pickr';
$('.trash').on('click', (e) => {
    $(e.target).parent().parent().parent().remove();
});
 $('.add').on('click', e => {
    $.ajax({
        type: "POST",
        url: '/addrank',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
        data: {},
        success: function(res) {
            window.location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log("Error occured during AJAX request, error code: " + xhr.status);
        },
    });
 });
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
});
$(".dropdown-menu p").mouseout(e => {
    let $ele = $(e.target);
    $ele.text($ele.text().replace(new RegExp("[-+]"), ""));
});
$('.color').each(function(i, obj) {
    let $id = $(obj).attr('id');
    let $HEXcolor = $(obj).attr('hex');
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
                rgba: false,
                hsla: false,
                hsva: false,
                cmyk: false,
                input: true,
                clear: true,
                save: true
            }
        }
    });
    setTimeout(function() {
        pickr.setColor($HEXcolor);
        pickr.on('save', () => {
            pickr.hide();
            $('#' + $id.substr('5')).attr('updated-hex', '#' + pickr.getColor().toHEXA().join(''));
        });
    }, 25);
});
$('.save').on('click', e => {
    let $ranksJson = [];
    $('.rank').each((i, e) => {
        let $name = $(e).find('.name').val();
        let $id = $(e).find('.name').attr('index');
        let $color = $(e).attr('updated-hex');
        let permsArray = [];
        $(e).find('.selected').each((i, e) => {
            permsArray[i] = ($(e).attr('id'));
        });
        let $jsonObj = {
            "id": $id,
            "name": $name,
            "color": $color,
            "perms": permsArray
        }
        $ranksJson.push($jsonObj);
    });
    $.ajax({
        type: "POST",
        url: '/updateranks',
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf"]').attr('content')},
        data: {"ranks" : JSON.stringify($ranksJson), "default": $('.selected-rank').attr('rankId')},
        success: function(res) {
            $('.result').html('<span style="color:green"> Saved. </span>');
            window.location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          console.log("Error occured during AJAX request, error code: " + xhr.status);
          $('.result').html('<span style="color:red"> Failed.<br/>Please check Console. </span>');
        },
    });
    $('.result').fadeOut(3000);
    setTimeout(() => {
        $('.result').html('');
        $('.result').show();
    }, 3000);
});
$('.dropdown-item').on('click', e => {
    let $rId = $(e.target).attr('id');
    let $rName = $(e.target).text();
    $('.selected-rank').attr('rankId', $rId);
    $('.selected-rank').text($rName);
});
updateColorScheme($('meta[name="color"]').attr('content'));
/**
 * Updates color scheme on present selectors.
 * 
 * @param {*} color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
    $('.add>i, svg').css("color", color);
}
