jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

jQuery(document).ready(function () {
    jQuery("body").on("click", "a, button, .back-link", function () {
        let text = jQuery(this).attr("data-question");
        if (text == undefined || confirm(text)) {
            if (jQuery(this).hasClass("back-link")) {
                let href = jQuery(this).attr("href");
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
    jQuery("#main-form").startForm();


    jQuery("body").on("click", ".beetle-tab .nav-link", function () {
        let box = jQuery(this).parents(".beetle-tab").eq(0);
        jQuery(box).find(".nav-link").removeClass("active");
        jQuery(this).addClass("active");
        let target = jQuery(this).attr("href");
        jQuery(box).find(".tab-pane").removeClass("active");
        jQuery(box).find(target).addClass("active");
        return false;
    });

});

function getHashValue(key) {
    let matches = location.hash.match(new RegExp(key + '=([^&]*)'));
    return matches ? matches[1] : null;
}
