//window.$ = window.jQuery = require('jquery');

window.getHashValue = function (key) {
    let matches = location.hash.match(new RegExp(key + '=([^&]*)'));
    return matches ? matches[1] : null;
}

require("./ajax-form");
require("./images-box");
require("./jquery.tablednd.0.5");
require("./relation-field");
require("./relation-items");
require("./relation-table");
require("./start-form");
require("./urls");
require("./main");
