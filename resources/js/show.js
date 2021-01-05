jQuery(document).ready(function () {
    if (getHashValue("scroll") !== null) {
        jQuery(document).scrollTop(getHashValue("scroll"));
        history.pushState("", document.title, window.location.pathname + window.location.search);
    }

    jQuery(".active-table-checkbox").change(function () {
        jQuery("#dataTable tbody input").prop("checked", jQuery(this).prop("checked"));
    });

    var IdOnStartDrag = new Array();
    jQuery("#dataTable").tableDnD({
        onDragClass: "thisDragRow",
        dragHandle: "dragRow",
        onDragStart: function (table, row) {
            IdOnStartDrag = new Array();
            jQuery("tbody tr td .dragRow", table).each(function (e) {
                IdOnStartDrag[IdOnStartDrag.length] = $(this).attr("rel");
            });

        },
        onDrop: function (table, row) {
            var nowId = new Array();
            $("tbody tr td .dragRow", table).each(function (e) {
                nowId[nowId.length] = $(this).attr("rel");
            });
            var shiftElements = new Array();
            for (var i = 0; i < IdOnStartDrag.length; i++) {
                if (IdOnStartDrag[i] !== nowId[i]) {
                    shiftElements[shiftElements.length] = new Array(nowId[i], IdOnStartDrag[i]);
                }
            }
            jQuery.ajax({
                type: "POST",
                url: urlAdmin + "DragAndDrop",
                data: ({row: shiftElements}),
                success: function (html) {
                }
            });
        }
    });

    jQuery(".active-record-box").click(function () {
        var box = jQuery(this);
        var id = jQuery(box).attr("data-id");
        var value = "Y";
        if (jQuery(box).hasClass("active")) {
            value = "N";
        }
        jQuery.ajax({
            type: "POST",
            url: urlAdmin + "Active",
            data: {
                id: id,
                value: value
            },
            success: function (html) {
                if (value == "Y") {
                    jQuery(box).addClass("active");
                } else {
                    jQuery(box).removeClass("active");
                }
            }
        });
    });

    startForm("#find-form")
});

