let urlAdmin = window.location.pathname;
urlAdmin = urlAdmin.split('/');

let ajaxFormUrl = "/" + urlAdmin[1] + "/system/form";

let relationUrl = "/" + urlAdmin[1] + "/system/relation";

let imageUrl = "/" + urlAdmin[1] + "/system/image";

urlAdmin = "/" + urlAdmin[1] + "/" + urlAdmin[2] + "/";
