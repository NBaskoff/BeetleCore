jQuery(document).ready(function () {
    if (getHashValue("scroll") !== null) {
        jQuery(document).scrollTop(getHashValue("scroll"));
        history.pushState("", document.title, window.location.pathname + window.location.search);
    }

    jQuery(".active-table-checkbox").change(function () {
        jQuery("#dataTable tbody input").prop("checked", jQuery(this).prop("checked"));
    });
});

function getHashValue(key) {
    var matches = location.hash.match(new RegExp(key+'=([^&]*)'));
    return matches ? matches[1] : null;
}
