jQuery(document).ready(function () {
    if (getHashValue("scroll") !== null) {
        jQuery(document).scrollTop(getHashValue("scroll"));
        history.pushState("", document.title, window.location.pathname + window.location.search);
    }

    jQuery(".active-table-checkbox").change(function () {
        jQuery("#dataTable tbody input").prop("checked", jQuery(this).prop("checked"));
    });

    let IdOnStartDrag = new Array();
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
            let nowId = new Array();
            $("tbody tr td .dragRow", table).each(function (e) {
                nowId[nowId.length] = $(this).attr("rel");
            });
            let shiftElements = new Array();
            for (let i = 0; i < IdOnStartDrag.length; i++) {
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
        let box = jQuery(this);
        let id = jQuery(box).attr("data-id");
        let value = "Y";
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


    //History
    let historyLinks = sessionStorage.getItem("historyLinks");
    if (historyLinks == null) {
        historyLinks = [];
    } else {
        historyLinks = JSON.parse(historyLinks);
    }
    let link = window.location.pathname + window.location.search;
    if (historyLinks.length == 0 || historyLinks[historyLinks.length - 1] != link) {
        historyLinks.push(link);
    }
    if (historyLinks.length > 1) {
        jQuery("#history-back").css("display", "block");
        jQuery("#page-title").removeClass("col-md-11").addClass("col-md-10");
    }
    sessionStorage.setItem("historyLinks", JSON.stringify(historyLinks));
    jQuery("#history-back").click(function () {
        historyLinks.pop();
        sessionStorage.setItem("historyLinks", JSON.stringify(historyLinks));
        window.location.href =  historyLinks.pop();
        return false;
    });

});

window.getHashValue = function (key) {
    let matches = location.hash.match(new RegExp(key + '=([^&]*)'));
    return matches ? matches[1] : null;
}
