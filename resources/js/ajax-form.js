(function (jQuery) {
    jQuery.fn.relationTable = function () {
        function main(box) {
            var dataField = "";
            var model = "";
            var ignoreId = 0;
            var parent = 0;
            var multiple = 0;
            var relationBox;
            var dialog;
            relationBox = box;
            dataField = jQuery(relationBox).attr("data-field");
            model = jQuery(relationBox).attr("data-model");
            ignoreId = jQuery(relationBox).attr("data-ignore-id");
            multiple = jQuery(relationBox).attr("data-multiple");
            parent = 0;

            jQuery(relationBox).on("click", ".relation-add-edit", function () {
                openDialog();
            });

            jQuery(relationBox).on("click", ".relation-ids .relation-id .close", function () {
                jQuery(this).parents(".relation-id").remove();
                return false;
            });

            function openDialog() {
                var ids = [];
                jQuery(".relation-ids .relation-id", relationBox).each(function () {
                    ids[ids.length] = jQuery(this).attr("data-id");
                });
                dialog = createDialogTabel();
                dialog.modal();
                jQuery.ajax({
                    url: relationUrl + "/form?model=" + model,
                    type: "POST",
                    data: {
                        ids: ids,
                    },
                    success: function (data) {
                        jQuery(".modal-body", dialog).html(data);
                        updateRelationTable(1, 0);

                        jQuery(dialog).on("click", ".relation-form .start-find", function () {
                            updateRelationTable(1, 0, true);
                            return false;
                        });

                        jQuery(dialog).on("click", ".relation-form .stop-find", function () {
                            updateRelationTable(1, 0, false);
                            return false;
                        });

                        jQuery(dialog).on("click", ".relation-id .close", function () {
                            var id = jQuery(this).parents(".relation-id").attr("data-id");
                            jQuery(this).parents(".relation-id").remove();
                            jQuery(dialog).find(".relation-table input[value=" + id + "]").prop("checked", false);
                            return false;
                        });

                        jQuery(dialog).on("click", ".pagination .page-item", function () {
                            jQuery(".pagination .page-item", dialog).removeClass("active");
                            jQuery(this).addClass("active");
                            updateRelationTable(parseInt(jQuery(this).text()), parent);
                            return false;
                        });

                        jQuery(dialog).on("click", ".table .relation-select", function () {
                            var input = jQuery(this).parents("tr").find("input");
                            var box = jQuery(this).parents(".relation-box");
                            var id = jQuery(input).val();

                            if (jQuery(input).prop("checked")) {
                                jQuery(box).find(".relation-id[data-id=" + id + "]").remove();
                                jQuery(input).prop('checked', false);
                            } else {
                                if (multiple != true) {
                                    jQuery(box).find(".relation-ids").html("");
                                    jQuery(box).find("input").prop('checked', false);
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

                        jQuery(dialog).on("click", ".table .relation-select-input", function () {
                            var input = jQuery(this).parents("tr").find("input");
                            var box = jQuery(this).parents(".relation-box");
                            var id = jQuery(input).val();

                            if (jQuery(input).prop("checked")) {
                                if (multiple != true) {
                                    jQuery(box).find(".relation-ids").html("");
                                    jQuery(box).find("input").prop('checked', false);
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

                        jQuery(dialog).on("click", ".relation-next-level", function () {
                            parent = jQuery(this).attr("data-id");
                            updateRelationTable(1, parent);
                        });

                        jQuery(dialog).on("click", ".dialog-save", function () {
                            jQuery(".relation-id", relationBox).remove();
                            jQuery(".relation-box .relation-id", dialog).each(function () {
                                var id = jQuery(this).attr("data-id");
                                var name = jQuery(this).text().trim();
                                jQuery(".relation-ids", relationBox).append(
                                    '<div class="relation-id" data-id="' + id + '">\n' +
                                    '<input type="hidden" name="' + dataField + '[id][]" value="' + id + '">' +
                                    '<input type="hidden" name="' + dataField + '[name][]" value="' + name + '">' +
                                    '' + name + '\n' +
                                    '<div class="close">\n' +
                                    '<i class="fas fa-times-circle"></i>\n' +
                                    '</div>\n' +
                                    '</div>'
                                );
                            });

                            /*if (jQuery(relationBox).parents(".relation-table").length > 0) {
                                var box = jQuery(relationBox).parents(".relation-table").eq(0);
                                var line = parseInt(jQuery(box).attr("data-lines"));
                                var tr = jQuery(relationBox).parents("tr").eq(0);
                                jQuery(".relation-box .relation-id", dialog).each(function () {
                                    jQuery(".relation-id", relationBox).remove();
                                    line = line + 1;
                                    var input = jQuery(tr).find(".relation-row-select");
                                    var id = jQuery(this).attr("data-id");
                                    var name = jQuery(this).text();
                                    jQuery(".relation-ids", relationBox).append(
                                        '<div class="relation-id" data-id="' + id + '">\n' +
                                        '<input type="hidden" name="' + dataField + '[id][]" value="' + id + '">' +
                                        '<input type="hidden" name="' + dataField + '[name][]" value="' + name + '">' +
                                        '' + name + '\n' +
                                        '<div class="close">\n' +
                                        '<i class="fas fa-times-circle"></i>\n' +
                                        '</div>\n' +
                                        '</div>'
                                    );
                                    var to = jQuery(box).attr("data-replace-copy");
                                    to = to.split("|line|").join(line);
                                    html = jQuery(tr).html();
                                    html = html.split(input.attr("data-replace-copy")).join(to);
                                    var trNew =jQuery("<tr>" + html + "</tr>");
                                    jQuery(tr).after(trNew);
                                    jQuery(box).find("table tbody").find("input[name='" + to + "[id]']").val("new");
                                    startForm(trNew);
                                });
                                jQuery(tr).remove();
                                jQuery(box).attr("data-lines", line);
                            } else {
                                jQuery(".relation-id", relationBox).remove();
                                jQuery(".relation-box .relation-id", dialog).each(function () {
                                    var id = jQuery(this).attr("data-id");
                                    var name = jQuery(this).text().trim();
                                    jQuery(".relation-ids", relationBox).append(
                                        '<div class="relation-id" data-id="' + id + '">\n' +
                                        '<input type="hidden" name="' + dataField + '[id][]" value="' + id + '">' +
                                        '<input type="hidden" name="' + dataField + '[name][]" value="' + name + '">' +
                                        '' + name + '\n' +
                                        '<div class="close">\n' +
                                        '<i class="fas fa-times-circle"></i>\n' +
                                        '</div>\n' +
                                        '</div>'
                                    );
                                });
                            }*/

                            jQuery(dialog).modal('hide');
                            return false;
                        });

                        jQuery(dialog).on("click", ".relation-form-add-open", function () {
                            jQuery(dialog).modal('hide');
                            var dialogFrom = createDialogForm();
                            dialogFrom.on("shown.bs.modal", function () {
                                jQuery(".modal-body form", dialogFrom).ajaxForm(relationBox);
                                //dialogFrom.modal('handleUpdate');
                            });
                            dialogFrom.modal();
                        });
                    }
                });
                return dialog;
            }

            function createDialogTabel() {
                if (jQuery(relationBox).attr("data-action") == "find") {
                    dialog = jQuery('<div class="modal fade relation-dialog" tabindex="-1" role="dialog" aria-hidden="true">\n' +
                        '    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">\n' +
                        '        <div class="modal-content">\n' +
                        '            <div class="modal-body">\n' +
                        '            </div>\n' +
                        '            <div class="modal-footer">\n' +
                        '               <div class="btn btn-primary dialog-save">Сохранить</div>\n' +
                        '               <div class="btn btn-secondary" data-dismiss="modal">Отмена</div>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '    </div>\n' +
                        '</div>');
                } else {
                    dialog = jQuery('<div class="modal relation-dialog" tabindex="-1" role="dialog" aria-hidden="true">\n' +
                        '    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">\n' +
                        '        <div class="modal-content">\n' +
                        '            <div class="modal-body">\n' +
                        '            </div>\n' +
                        '            <div class="modal-footer modal-footer-relation">\n' +
                        '               <div class="btn btn-primary relation-form-add-open">Добавить</div>\n' +
                        '               <div class="control">\n' +
                        '                   <div class="btn btn-primary dialog-save">Сохранить</div>\n' +
                        '                   <div class="btn btn-secondary" data-dismiss="modal">Отмена</div>\n' +
                        '               </div>\n' +
                        '            </div>\n' +
                        '        </div>\n' +
                        '    </div>\n' +
                        '</div>');
                }
                dialog.on('hidden.bs.modal', function (e) {
                    jQuery(e.target).remove();
                });
                return dialog;
            }

            function createDialogForm() {
                dialog = jQuery('<div class="modal relation-form-dialog" tabindex="-1" role="dialog" aria-hidden="true">\n' +
                    '    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">\n' +
                    '        <div class="modal-content">\n' +
                    '            <div class="modal-body">\n' +
                    '               <form class="ajax-form ajax-form-load" data-model="' + model + '" data-id="" data-parent="' + jQuery(relationBox).attr("data-link-self") + '" data-parent-id="' + parent + '" method="POST" encType="multipart/form-data">\n' +
                    '               </form>\n' +
                    '            </div>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</div>');
                dialog.on('hidden.bs.modal', function (e) {
                    jQuery(e.target).remove();
                });
                return dialog;
            }

            function updateRelationTable(page, parent, find = false) {
                var ids = [];
                jQuery(".relation-ids .relation-id", dialog).each(function () {
                    ids[ids.length] = jQuery(this).attr("data-id");
                });
                var data = {
                    //find: data,
                    ids: ids,
                    page: page,
                    ignore: ignoreId,
                    parent: parent
                };
                if (find == true) {
                    data.find = jQuery(dialog).find(".relation-form").serialize();
                }
                jQuery.ajax({
                    url: relationUrl + "/table?model=" + model,
                    type: "POST",
                    data: data,
                    success: function (data) {
                        jQuery(dialog).find(".relation-table").html(data);
                    }
                });
                return false;
            }
        }


        this.each(function () {
            main(jQuery(this));
        });
        return this;
    };

})(jQuery);
