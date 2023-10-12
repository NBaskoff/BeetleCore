window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js');
require('bootstrap/dist/js/bootstrap.min');
//require('jquery-ui/dist/jquery-ui');
require("jquery-ui/ui/core");
require("jquery-ui/ui/widgets/sortable");
require("jquery-ui/ui/disable-selection");
require("jquery-cropper/dist/jquery-cropper");
//require("inputmask/dist/jquery.inputmask");
require("jquery-form/dist/jquery.form.min");
require("tablednd");
//require("magnific-popup");

require("tinymce/tinymce.min");
require("tinymce/themes/silver");
require("tinymce/icons/default");
require('tinymce/plugins/code/plugin.min');
require('tinymce/plugins/image/plugin.min');
require('tinymce/plugins/link/plugin.min');
require('tinymce/plugins/paste/plugin.min');
require('tinymce/plugins/print/plugin.min');
require('tinymce/plugins/table/plugin.min');
require('tinymce/plugins/media/plugin.min');
require('tinymce/plugins/wordcount/plugin.min');
require('tinymce/plugins/fullscreen/plugin.min');
require("./tinymce.lang.ru");
require("@tinymce/tinymce-jquery");

/*import 'tinymce/skins/ui/oxide/skin.min.css';
import contentUiCss from 'tinymce/skins/ui/oxide/content.css';
import contentCss from 'tinymce/skins/content/default/content.css';*/

window.getHashValue = function (key) {
    let matches = location.hash.match(new RegExp(key + '=([^&]*)'));
    return matches ? matches[1] : null;
}

require("./urls");
require("./images-box");
require("./relation-field");
require("./relation-table");
require("./relation-items");
require("./start-form");
require("./ajax-form");
require("./file");
require("./main");
