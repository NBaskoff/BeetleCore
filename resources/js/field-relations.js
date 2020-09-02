jQuery(document).ready(function () {
    var relationUrl = window.location.pathname;
    relationUrl = relationUrl.split('/');
    relationUrl = "/" + relationUrl[1] + "/relation";

    var relationDataField = "";
    var relationModel = "";
    var relationBox = "";
    var relationIgnoreId = 0;
    var relationParent = 0;
    var relationMultiple = 0;
    jQuery(".relation-add-edit").click(function () {
        jQuery("#modalRelation .modal-body").html("");
        jQuery("#modalRelation").modal();
        var ids = [];
        relationModel = jQuery(this).attr("data-model");
        relationDataField = jQuery(this).attr("data-field");
        relationBox = jQuery(this).parents(".relation-form-box");
        relationIgnoreId = jQuery(this).attr("data-ignore-id");
        relationMultiple = jQuery(this).attr("data-multiple");
        relationParent = 0;
        jQuery(this).parents(".relation-form-box").find(".relation-id").each(function () {
            ids[ids.length] = jQuery(this).attr("data-id");
        });
        jQuery.ajax({
            url: relationUrl + "/form/" + relationModel,
            type: "POST",
            data: {
                ids: ids,
            },
            success: function (data) {
                jQuery("#modalRelation .modal-body").html(data);
                updateRelationTable(1, 0);
            }
        });
        return false;
    });
    jQuery("#modalRelation .relation-save").click(function () {
        jQuery(".relation-id", relationBox).remove();

        jQuery("#modalRelation .relation-box .relation-id").each(function () {
            var id = jQuery(this).attr("data-id");
            var name = jQuery(this).text();
            jQuery(".relation-ids", relationBox).append(
                '<div class="relation-id" data-id="' + id + '">\n' +
                '<input type="hidden" name="' + relationDataField + '[]" value="' + id + '">' +
                '' + name + '\n' +
                '<div class="close">\n' +
                '<i class="fas fa-times-circle"></i>\n' +
                '</div>\n' +
                '</div>'
            );
        });

        jQuery("#modalRelation").modal('hide');
        return false;
    });

    jQuery(".relation-form-box").on("click", ".relation-ids .relation-id .close", function () {
        jQuery(this).parents(".relation-id").remove();
        return false;
    });

    var parentBox = jQuery("#modalRelation");

    jQuery(parentBox).on("click", ".relation-form .start-find", function () {
        updateRelationTable(1, 0, true);
        return false;
    });
    jQuery(parentBox).on("click", ".relation-form .stop-find", function () {
        updateRelationTable(1, 0, false);
        return false;
    });
    jQuery(parentBox).on("click", ".relation-id .close", function () {
        var box = jQuery(this).parents(".relation-box");
        var id = jQuery(this).parents(".relation-id").attr("data-id");
        jQuery(this).parents(".relation-id").remove();
        jQuery(box).find(".relation-table input[value=" + id + "]").prop("checked", false);
        return false;
    });

    jQuery(parentBox).on("click", ".pagination .page-item", function () {
        jQuery(".pagination .page-item", parentBox).removeClass("active");
        jQuery(this).addClass("active");
        updateRelationTable(jQuery(this).text(), relationParent);
        return false;
    });

    jQuery(parentBox).on("click", ".table .relation-select", function () {
        var input = jQuery(this).parents("tr").find("input");
        var box = jQuery(this).parents(".relation-box");
        var id = jQuery(input).val();

        if (jQuery(input).prop("checked")) {
            jQuery(box).find(".relation-id[data-id=" + id + "]").remove();
            jQuery(input).prop('checked', false);
        } else {
            if (relationMultiple != true) {
                jQuery(box).find(".relation-ids").html("");
                jQuery(parentBox).find("input").prop('checked', false);
            }

            jQuery(box).find(".relation-ids").append(
                '<div class="relation-id" data-id="' + id + '">\n' +
                jQuery(input).attr("data-name") +
                '<div class="close">\n' +
                '<i class="fas fa-times-circle"></i>\n' +
                '</div>\n' +
                '</div>');
            jQuery(input).prop('checked', true);
        }
        return false;
    });

    jQuery(parentBox).on("click", ".table .relation-select-input", function () {
        var input = jQuery(this).parents("tr").find("input");
        var box = jQuery(this).parents(".relation-box");
        var id = jQuery(input).val();

        if (jQuery(input).prop("checked")) {
            if (relationMultiple != true) {
                jQuery(box).find(".relation-ids").html("");
                jQuery(parentBox).find("input").prop('checked', false);
            }
            jQuery(box).find(".relation-ids").append(
                '<div class="relation-id" data-id="' + id + '">\n' +
                jQuery(input).attr("data-name") +
                '<div class="close">\n' +
                '<i class="fas fa-times-circle"></i>\n' +
                '</div>\n' +
                '</div>');
            jQuery(input).prop('checked', true);
        } else {
            jQuery(box).find(".relation-id[data-id=" + id + "]").remove();
            jQuery(input).prop('checked', false);
        }
    });

    jQuery(parentBox).on("click", ".relation-next-level", function () {
        updateRelationTable(1, jQuery(this).attr("data-id"));
    });


    function updateRelationTable(page, parent, find = false) {
        var box = jQuery("#relation" + relationModel);
        var ids = [];
        jQuery("#modalRelation .relation-box .relation-id").each(function () {
            ids[ids.length] = jQuery(this).attr("data-id");
        });
        var data = {
            //find: data,
            ids: ids,
            page: page,
            ignore: relationIgnoreId,
            parent: parent
        };
        if (find == true) {
            data.find = jQuery(box).find(".relation-form").serialize();
        }
        jQuery.ajax({
            url: relationUrl + "/table/" + relationModel,
            type: "POST",
            data: data,
            success: function (data) {
                jQuery(box).find(".relation-table").html(data);
            }
        });
        return false;
    }

});


