var urlAdmin = window.location.pathname;
urlAdmin = urlAdmin.split('/');

var ajaxFormUrl = "/" + urlAdmin[1] + "/system/form";

var relationUrl = "/" + urlAdmin[1] + "/system/relation";

var imageUrl = "/" + urlAdmin[1] + "/system/image";

urlAdmin = "/" + urlAdmin[1] + "/" + urlAdmin[2] + "/";
