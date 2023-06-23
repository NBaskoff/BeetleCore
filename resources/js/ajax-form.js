(function (jQuery) {
    jQuery.fn.ajaxForm = function (relationBox) {
        function main(formBox) {
            let modelName;
            let parent;
            let parentId;
            let recordId;
            let box;

            box = formBox;
            modelName = jQuery(box).attr("data-model");
            parent = jQuery(box).attr("data-parent");
            parentId = jQuery(box).attr("data-parent-id");
            recordId = jQuery(box).attr("data-id");
            if (jQuery(box).hasClass("ajax-form-load")) {
                loadForm();
            }
            jQuery(box).startForm();
            if (relationBox == undefined) {
                jQuery(".btn-back", box).click(function () {
                    document.location.href = jQuery(box).attr("data-back") + "#scroll=" + getHashValue("scroll");
                });
            }
            jQuery(box).submit(function (e) {
                e.preventDefault()
                let options = {
                    url: ajaxFormUrl + "/save",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        system: {
                            modelName: modelName,
                            parent: parent,
                            parentId: parentId,
                            recordId: recordId
                        }
                    },
                    /*cache: false,
                    async: false,*/
                    beforeSubmit: function (data) {
                        jQuery(".is-invalid", box).removeClass("is-invalid");
                        jQuery(".invalid-feedback", box).text("");
                    },
                    success: function (data) {
                        if (data.error !== null) {
                            let error = null;
                            for (let key in data.error) {
                                let val = data.error[key];
                                if (val.length > 0) {
                                    jQuery(".invalid-feedback-" + key + "", box).text(val);
                                    jQuery("*[name=" + key + "]", box).addClass("is-invalid");
                                    if (error == null) {
                                        error = jQuery("*[name=" + key + "]", box);
                                    }
                                }
                            }
                            if (relationBox == undefined) {
                                jQuery('body,html').animate({scrollTop: jQuery(error).offset().top - jQuery(window).height() / 2}, 300);
                            } else {
                                let thisDialog = jQuery(box).parents(".relation-form-dialog");
                                thisDialog.animate({scrollTop: jQuery(error).offset().top - jQuery(thisDialog).height() / 2}, 300);
                            }
                        } else {
                            if (relationBox == undefined) {
                                document.location.href = jQuery(box).attr("data-back") + "#scroll=" + getHashValue("scroll");
                            } else {
                                jQuery(box).parents(".relation-form-dialog").modal("hide");
                                if (jQuery(relationBox).attr("data-multiple") != 1) {
                                    jQuery(".relation-id", relationBox).remove();
                                }
                                jQuery(".relation-ids", relationBox).append(
                                    '<div class="relation-id" data-id="' + data.recordId + '">\n' +
                                    '<input type="hidden" name="' + jQuery(relationBox).attr("data-field") + '[id][]" value="' + data.recordId + '">' +
                                    '' + data.recordName + '\n' +
                                    '<div class="close">\n' +
                                    '<i class="fas fa-times-circle"></i>\n' +
                                    '</div>\n' +
                                    '</div>'
                                );
                            }
                        }
                        return false;
                    }
                };
                jQuery(this).ajaxSubmit(options);
                return false;
            });

            function loadForm() {
                jQuery.ajax({
                    type: "POST",
                    url: ajaxFormUrl + "/load",
                    data: {
                        modelName: modelName,
                        parent: parent,
                        parentId: parentId,
                        recordId: recordId
                    },
                    cache: false,
                    async: false,
                    //timeout: 600000,
                    dataType: 'text',
                    success: function (data) {
                        jQuery(box).html(data);
                    },
                    error: function (e) {

                    }
                });
            }
        }

        this.each(function () {
            main(jQuery(this));
        });
        return this;
    };
})(jQuery);

