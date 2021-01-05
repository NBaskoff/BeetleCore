
jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

jQuery(document).ready(function () {
    jQuery("body").on("click", "a, button, .back-link", function () {
        var text = jQuery(this).attr("data-question");
        if (text == undefined || confirm(text)) {
            if (jQuery(this).hasClass("back-link")) {
                var href = jQuery(this).attr("href");
                href = href + "#scroll=" + jQuery(document).scrollTop();
                window.location = href;
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    });

    /*$(".chosen-select").chosen({
        no_results_text: "Ничего не найдено",
        allow_single_deselect: true,
        disable_search_threshold: 1
    });*/

    jQuery(".ajax-form").ajaxForm();

});

function getHashValue(key) {
    var matches = location.hash.match(new RegExp(key + '=([^&]*)'));
    return matches ? matches[1] : null;
}
