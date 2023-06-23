let url = window.location.pathname;
url = url.split('/');

window.ajaxFormUrl = "/" + url[1] + "/system/form";

window.relationUrl = "/" + url[1] + "/system/relation";

window.imageUrl = "/" + url[1] + "/system/image";

window.urlAdmin = "/" + url[1] + "/" + url[2] + "/";
