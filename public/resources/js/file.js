jQuery(document).ready(function () {
    jQuery("body").on("click", ".admin-field-files-box .select-file", function () {
        let fileBox = jQuery(this).parents(".admin-field-files-box");
        let inputFileLoad = jQuery("<input>", {
            "type": "file",
            change: function (e) {
                loadFile(e.target.files[0]);
            }
        });
        inputFileLoad.click();

        function loadFile(file) {
            let status = jQuery(fileBox).find(".status");
            let dataArray = new FormData();
            dataArray.append('file', file);

            jQuery.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "/admin/system/file/load",
                data: dataArray,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                dataType: 'json',
                success: function (data) {
                    fileBox.find("input").val(JSON.stringify(data));
                    status.text('Файл ' + data.name + ' успешно загружен');
                },
                error: function (e) {

                },
                xhr: function () {
                    let xhr = $.ajaxSettings.xhr();
                    xhr.upload.onprogress = function (event) {
                        //status.text('Загружено ' + event.loaded + ' из ' + event.total);
                        status.text('Загружено ' + (event.loaded / event.total * 100).toFixed(2));
                        //console.log('progress', evt.loaded/evt.total*100)
                    };
                    xhr.upload.onload = function (event) {

                    };
                    return xhr;
                }
            });
        }
    });
});
