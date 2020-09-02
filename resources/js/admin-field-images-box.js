jQuery(document).ready(function () {
    var imagesBox;
    var imageWidth = 0;
    var imageHeight = 0;
    var imageField = 0;
    var imageName = "";
    var imageInLoad = 0;

    jQuery(".admin-field-images-box .select-file").click(function () {
        imagesBox = jQuery(this).parents(".admin-field-images-box").eq(0);
        imageWidth = jQuery(imagesBox).attr("data-width");
        imageHeight = jQuery(imagesBox).attr("data-height");
        imageField = jQuery(imagesBox).attr("data-filed");
        imageInLoad = 0;


        var inputFileLoad = jQuery("<input>", {
            "type": "file",
            multiple: 1,
            accept: ".jpeg,.jpg,.png",
            change: function (e) {
                imageInLoad = e.target.files.length;
                imagesBox.find(".image-load").css("display", "block");
                for (var i = 0; i < e.target.files.length; i++) {
                    file = e.target.files[i];
                    var dataArray = new FormData();
                    dataArray.append('file', file);
                    dataArray.append('width', imageWidth);
                    dataArray.append('height', imageHeight);
                    dataArray.append('field', imageField);

                    $.ajax({
                        type: "POST",
                        enctype: 'multipart/form-data',
                        url: "/admin/load",
                        data: dataArray,
                        processData: false,
                        contentType: false,
                        cache: false,
                        timeout: 600000,
                        dataType: 'text',
                        success: function (data) {
                            jQuery(imagesBox).find(".images-list-box").append(data);
                            imageInLoad = imageInLoad - 1;
                            hideLoad();
                        },
                        error: function (e) {
                            imageInLoad = imageInLoad - 1;
                            hideLoad();
                        }
                    });
                }
            }
        });
        inputFileLoad.click();
    });

    function hideLoad() {
        if (imageInLoad == 0) {
            imagesBox.find(".image-load").css("display", "none");
        }
    }

    jQuery(".admin-field-images-box").on("click", ".image-box .edit", function () {
        imagesBox = jQuery(this).parents(".admin-field-images-box").eq(0);
        imageWidth = jQuery(imagesBox).attr("data-width");
        imageHeight = jQuery(imagesBox).attr("data-height");
        imageField = jQuery(imagesBox).attr("data-filed");
        imagesBox = jQuery(this).parents(".image-box");
        imageName = imagesBox.attr("data-name");
        jQuery("#modalCropper #image").cropper("destroy");
        jQuery("#modalCropper #image").attr("src", imagesBox.attr("data-file"));
        jQuery("#modalCropper").modal({backdrop: 'static', keyboard: false});
    });
    jQuery(".admin-field-images-box").on("click", ".image-box .del", function () {
        if (confirm("Удалить картинку?")) {
            jQuery(this).parents(".image-box").remove();
        }
    });
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
            url: "/admin/size",
            type: "POST",
            data: data,
            success: function (data) {
                imagesBox.replaceWith(data);
                jQuery("#modalCropper").modal('hide');
            }
        });
    });


});
