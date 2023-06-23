jQuery(document).ready(function () {
    jQuery("body").on("click", ".relation-items-add", function(){
        let box = jQuery(this).parents(".relation-items");
        let html = jQuery(box).find(".relation-items-add-box").html();
        let line = parseInt(jQuery(box).attr("data-lines")) + 1;
        jQuery(box).attr("data-lines", line);
        html = html.split("|line|").join(line);
        let item = jQuery(box).find(".items-box").append(html);
        startForm(item);
    });
    jQuery("body").on("click", ".relation-items-delete", function() {
        if (confirm("Удалить запись?")) {
            jQuery(this).parents(".relation-items-box").eq(0).remove();
        }
    });
});
