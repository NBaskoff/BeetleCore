function startForm(box) {
    jQuery(".admin-field-images-box", box).imageBox();

    jQuery(".relation-form-box", box).relationTable();

    jQuery('.tinymce', box).tinymce({
        language: "ru",
        theme: "modern",
        extended_valid_elements: 'script[type|charset|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],div[*],p[*],object[width|height|classid|codebase|embed|param],param[name|value],embed[param|src|type|width|height|flashvars|wmode]',
        //plugins : "advlist,anchor,autolink,autoresize,autosave,bbcode,charmap,code,colorpicker,contextmenu,directionality,emoticons,fullpage,fullscreen,hr,image,importcss,insertdatetime,layer,legacyoutput,link,lists,media,nonbreaking,noneditable,pagebreak,paste,preview,print,save,searchreplace,spellchecker,tabfocus,table,template,textcolor,textpattern,visualblocks,visualchars,wordcount",
        plugins: "code,fullscreen,paste,image,link,media,print,wordcount,table",
        // Theme options
        //theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        //theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,images,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        //theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        relative_urls: false,
        convert_urls: false,
    });

    jQuery(".admin-field-images-box", box).on("click", ".image-box .edit", function () {
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

    jQuery(".images-list-box").disableSelection();

    jQuery(".images-list-box").sortable({
        placeholder: "image-box image-box-placeholder",
        start: function (event, ui) {
            jQuery(".image-box-placeholder").css("height", jQuery(ui.item).height());
        },
        update: function (event, ui) {}
    });

}
