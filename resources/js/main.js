jQuery(document).ready(function () {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = window.location.pathname;
    url = url.split('/');
    url = "/" + url[1] + "/" + url[2] + "/";

    var IdOnStartDrag = new Array();
    $("#dataTable").tableDnD({
        onDragClass: "thisDragRow",
        dragHandle: "dragRow",
        onDragStart: function (table, row) {
            IdOnStartDrag = new Array();
            $("tbody tr td .dragRow", table).each(function (e) {
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
                /*headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },*/
                type: "POST",
                url: url + "DragAndDrop",
                data: ({row: shiftElements}),
                success: function (html) {

                }
            });
        }
    });
    jQuery("body").on("click", "a", function () {
        var text = jQuery(this).attr("question");
        if (text != undefined) {
            return confirm(text);
        } else {
            return true;
        }
    });
    /*jQuery(".btn-back").on("click", function () {
        if (history.length > 1) {
            history.go(-1);
            return false;
        }
    });*/



    $('.tinymce').tinymce({
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

    /*$(".chosen-select").chosen({
        no_results_text: "Ничего не найдено",
        allow_single_deselect: true,
        disable_search_threshold: 1
    });*/

});
