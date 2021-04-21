jQuery(document).ready(function () {
    jQuery("body").on("click", ".relation-items-add", function(){
        var box = jQuery(this).parents(".relation-items");
        var html = jQuery(box).find(".relation-items-add-box").html();
        var line = parseInt(jQuery(box).attr("data-lines")) + 1;
        jQuery(box).attr("data-lines", line);
        html = html.split("|line|").join(line);
        var item = jQuery(box).find(".items-box").append(html);
        startForm(item);
    });
    jQuery("body").on("click", ".relation-items-delete", function() {
        if (confirm("Удалить запись?")) {
            jQuery(this).parents(".relation-items-box").eq(0).remove();
        }
    });
});
