jQuery(document).ready(function () {
    (function ($) {
        jQuery.fn.imageBox = function (options) {
            // опции
            let config = $.extend({}, {
                op1: '',
                op2: ''
            }, options);

            function main(imagesBox) {
                jQuery(".select-file", imagesBox).click(function () {
                    let inputFileLoad = jQuery("<input>", {
                        "type": "file",
                        multiple: 1,
                        accept: ".jpeg,.jpg,.png",
                        change: function (e) {
                            for (let i = 0; i < e.target.files.length; i++) {
                                loadFile(e.target.files[i], imagesBox);
                            }
                        }
                    });
                    inputFileLoad.click();
                });

                jQuery(imagesBox).on("click", ".image-box .del", function () {
                    if (confirm("Удалить картинку?")) {
                        jQuery(this).parents(".image-box").remove();
                    }
                });
            }

            function loadFile(file, imagesBox) {
                let imageWidth = jQuery(imagesBox).attr("data-width");
                let imageHeight = jQuery(imagesBox).attr("data-height");
                let imageField = jQuery(imagesBox).attr("data-filed");

                let loadBox = jQuery(imagesBox).find(".image-load").clone();
                loadBox.removeClass("image-load");
                loadBox.css("display", "block");
                loadBox.find(".name").text(file.name);
                jQuery(".images-list-box", imagesBox).append(loadBox);

                let dataArray = new FormData();
                dataArray.append('file', file);
                dataArray.append('width', imageWidth);
                dataArray.append('height', imageHeight);
                dataArray.append('field', imageField);

                jQuery.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: imageUrl + "/load",
                    data: dataArray,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    dataType: 'text',
                    success: function (data) {
                        jQuery(loadBox).after(data);
                        jQuery(loadBox).remove();
                    },
                    error: function (e) {
                        jQuery(loadBox).remove();
                    }
                });
            }

            this.each(function () {
                main(jQuery(this));
            });
            return this;
        };

    })(jQuery);

    jQuery('#modalCropper').on('shown.bs.modal', function (e) {
        jQuery("#modalCropper #image").cropper({
            aspectRatio: imageWidth / imageHeight,
            zoomOnWheel: false,
            dragMode: "none",
        });
    });

    jQuery("#modalCropper .close").click(function () {
        jQuery("#modalCropper").modal('hide');
    });

    jQuery("#modalCropper .zoom-in").click(function () {
        jQuery("#modalCropper #image").cropper("zoom", 0.1);
    });
    jQuery("#modalCropper .zoom-out").click(function () {
        jQuery("#modalCropper #image").cropper("zoom", -0.1);
    });

    jQuery("#modalCropper .move-left").click(function () {
        jQuery("#modalCropper #image").cropper("move", 10, 0);
    });
    jQuery("#modalCropper .move-right").click(function () {
        jQuery("#modalCropper #image").cropper("move", -10, 0);
    });
    jQuery("#modalCropper .move-up").click(function () {
        jQuery("#modalCropper #image").cropper("move", 0, 10);
    });
    jQuery("#modalCropper .move-down").click(function () {
        jQuery("#modalCropper #image").cropper("move", 0, -10);
    });

    jQuery("#modalCropper .rotate-left").click(function () {
        jQuery("#modalCropper #image").cropper("rotate", 45);
    });

    jQuery("#modalCropper .rotate-right").click(function () {
        jQuery("#modalCropper #image").cropper("rotate", -45);
    });

    jQuery("#modalCropper .save").click(function () {
        data = jQuery("#modalCropper #image").cropper("getData");
        data.file = $('#image').attr("src");
        data.canvas = [imageWidth, imageHeight];
        data.name = imageName;
        data.field = imageField;
        jQuery.ajax({
            url: imageUrl + "/size",
            type: "POST",
            data: data,
            success: function (data) {
                imagesBox.replaceWith(data);
                jQuery("#modalCropper").modal('hide');
            }
        });
    });
});
