
import '@simonwep/pickr/dist/themes/nano.min.css';
import Pickr from '@simonwep/pickr';

/**
 * Create Color Scheme Pickr object.
 */
const pickr = Pickr.create({
    el: '.pickr',
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
/**
 * Listener for editor-state toggle button.
 */
$("#toggle").change(function() {
    saveEditorMode(this.checked);
    $('#editor-state').text(this.checked == 0 ? "OFF" : "ON");
    if(this.checked == 1) $('#editor-state').css('color', 'green');
    else $('#editor-state').css('color', 'red');
});

/**
 * Listener for settings save button.
 */
pickr.on('save', (hco, instance) => {
    let color = hco.toHEXA().toString();
    saveColor(color);
    $('#color-state').text(color);
    updateColorScheme(color);
    pickr.hide();
});

/**
 * Listener for Pickr initialization, load admin properties
 */
pickr.on('init', instance => {
    loadProperties(null);
});
loadProperties();

/**
 * Load admin properties.
 * 
 * @param {boolean} toggle 
 */
function loadProperties(toggle) {
    let $color = $('meta[name="color-scheme"]').attr("content");
    let $editormode = $('meta[name="editor-mode"]').attr("content");
    if(toggle == null) toggle = $editormode;
    console.log($editormode);
    $('#color-state').text($color);
    pickr.setColor($color);
    $('#editor-state').text(toggle == 0 ? "OFF" : "ON");
    if(toggle == 1) {
        $('#toggle').prop('checked', true);
        $('#editor-state').css('color', 'green');
    } else {
        $('#toggle').prop('checked', false);
        $('#editor-state').css('color', 'red');
    }
    updateColorScheme($color);
}
/**
 * Save color theme to DB.
 * 
 * @param {String} color 
 */
function saveColor(color) {
    $.ajax({
        type: "POST",
        url: "/postColorUpdate",
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
        data: { color: color },
        success: function(res) {
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(
                "Error occured during AJAX request, error code: " +
                    xhr.status
            );
        }
    });
}

/**
 * Save editor mode as toggled true or false.
 * 
 * @param {boolean} toggle 
 */
function saveEditorMode(toggle) {
    let boolAsNum = toggle ? 1 : 0;
    $.ajax({
        type: "POST",
        url: "/postEditorModeUpdate",
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
        data: { toggle:boolAsNum },
        success: function(res) {
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(
                "Error occured during AJAX request, error code: " +
                    xhr.status
            );
        }
    });
}
/**
 * Submit settings.
 */
$('.submit-settings').on('click', e => {
    let $threadTitleLen = $('#thread-title-input').val();
    let $threadOPLen = $('#thread-op-input').val();
    let $threadPostLen = $('#thread-post-input').val();
    let $profileNameLen = $('#profile-name-input').val();
    if(isNaN($threadTitleLen) || isNaN($threadOPLen) || isNaN($threadPostLen)) {
        $('.result-msg').remove();
        $('#result-placement').append('<p class="result-msg" style="color:red; font-size: 2vh;"> Values must be numerical! </p>');
        $('.result-msg').fadeOut(3000);
    } else if(isNaN($profileNameLen)) {
        $('.result-msg').remove();
        $('#result-placement').append('<p class="result-msg" style="color:red; font-size: 2vh;"> Values must be numerical! </p>');
        $('.result-msg').fadeOut(3000);
        } else {
    $.ajax({
        type: "POST",
        url: "/updatesettings",
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf"]').attr("content") },
        data: { titleLength:$threadTitleLen, opLength:$threadOPLen, postLength:$threadPostLen, profileNameLen:$profileNameLen },
        success: function(res) {
            $('.result-msg').remove();
            $('#result-placement').append('<p class="result-msg" style="color:green; font-size: 2vh;"> Values Updated! </p>');
            $('.result-msg').fadeOut(3000);
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
/**
 * Updates color scheme on present selectors.
 * 
 * @param {String} (hex) color 
 */
function updateColorScheme(color) {
    $('#header').css('background', color);
    $('#data-mgmt').css('color', color);
}
