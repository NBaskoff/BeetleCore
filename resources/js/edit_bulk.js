jQuery(document).ready(function () {
    jQuery(".bulk-record-box .bulk-record-checkbox").change(function () {
        jQuery(this).parents(".bulk-record-box").find(".bulk-record-value").toggleClass("active");
    });
});
