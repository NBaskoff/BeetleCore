jQuery(document).ready(function () {
    jQuery(".relation-table-add").click(function () {
        var box = jQuery(this).parents(".relation-table");
        var html = jQuery(box).find(".relation-table-add-line").html();
        var line = parseInt(jQuery(box).attr("data-lines")) + 1;
        jQuery(box).attr("data-lines", line);
        html = html.split("|line|").join(line);
        var tr = jQuery("<tr>" + html + "</tr>");
        jQuery(box).find("table tbody").append(tr);
        startForm(tr);
    });

    jQuery("body").on("click", ".relation-table-delete-line", function () {
        jQuery(this).parents("tr").remove();
        return false;
    });
    jQuery(".relation-table-copy").click(function () {
        var box = jQuery(this).parents(".relation-table");
        var html = jQuery(box).find(".relation-table-add-line").html();
        var line = parseInt(jQuery(box).attr("data-lines"));
        jQuery(box).find("table tbody tr").each(function () {
            var input = jQuery(this).find(".relation-row-select");
            if (input.prop("checked")) {
                line = line + 1;
                var to = jQuery(box).attr("data-replace-copy");
                to = to.split("|line|").join(line);
                html = jQuery(this).html();
                html = html.split(input.attr("data-replace-copy")).join(to);
                jQuery(box).find("table tbody").append("<tr>" + html + "</tr>");
                jQuery(box).find("table tbody").find("input[name='" + to + "[id]']").val("new");
            }
        });
        jQuery(box).find("table tbody .relation-row-select").prop("checked", false);
        jQuery(box).attr("data-lines", line);
    });

    jQuery(".relation-table-del").click(function () {
        var box = jQuery(this).parents(".relation-table");
        jQuery(box).find("table tbody tr").each(function () {
            var input = jQuery(this).find(".relation-row-select");
            if (input.prop("checked")) {
                jQuery(this).remove();
            }
        });
        return false;
    });

});
