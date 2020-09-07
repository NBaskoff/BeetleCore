<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fengyuanchen/cropperjs/dist/cropper.min.css" crossorigin="anonymous">
    {{--<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/harvesthq/chosen-package/chosen.min.css">--}}
    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1/resources/css/styles.css">
    <style>
        @media (min-width: 1400px) {
            .container {
                max-width: 1350px;
            }
        }
    </style>
    <title>@yield('title') :: BeetleCMS</title>
</head>
<body>
<!-- Modal Relation -->
<div class="modal fade" id="modalRelation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <div class="btn btn-primary relation-save">Сохранить</div>
                <div class="btn btn-secondary" data-dismiss="modal">Отмена</div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{route("admin.index")}}">BeetleCMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route("admin.page", "show")}}">Страницы</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Каталог
                        <!--Заказы и способы-->
                    </a>
                    <div class="dropdown-menu" aria-labelledby="orderDropdown">
                        <a class="dropdown-item" href="{{route("admin.catalog", "show")}}">Каталог</a>
                        <a class="dropdown-item" href="{{route("admin.catalog_items", "show")}}">Товары</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Пользователи
                        <!--Заказы и способы-->
                    </a>
                    <div class="dropdown-menu" aria-labelledby="orderDropdown">
                        <a class="dropdown-item" href="{{route("admin.user", "show")}}">Пользователи сайта</a>
                        <a class="dropdown-item" href="{{route("admin.user_admin", "show")}}">Администраторы CRM</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("admin.slider", "show")}}">Слайдер</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Настройки
                        <!--Заказы и способы-->
                    </a>
                    <div class="dropdown-menu" aria-labelledby="orderDropdown">
                        <a class="dropdown-item" href="{{route("admin.settings", "show")}}">Настройки сайта</a>
                        <a class="dropdown-item" href="{{route("admin.delivery", "show")}}">Способы доставки</a>
                        <a class="dropdown-item" href="{{route("admin.payment", "show")}}">Способы оплаты</a>
                    </div>
                </li>
                {{--<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Справочники
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>--}}
            </ul>
            <div class="form-inline my-2 my-lg-0">
            <span
                style="margin-right: 10px;">Добрый день, {{request()->session()->get("admin")->getAttribute("name")}}.</span>
                <a href="{{route("admin.exit")}}" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i>
                    Выход</a>
            </div>
        </div>
    </nav>
    @yield('content')
</div>

<script src="//cdn.jsdelivr.net/gh/jquery/jquery@3.5.0/dist/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1/resources/tinymce/tinymce.min.js"></script>
<script src="//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1/resources/tinymce/jquery.tinymce.min.js"></script>
<script src="//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1/resources/tinymce/tinymcego.js"></script>

<script src="//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1/resources/js/jquery.tablednd.0.5.js"></script>

{{--<script src="//cdn.jsdelivr.net/gh/harvesthq/chosen-package/chosen.jquery.min.js"></script>--}}

<script src="//cdn.jsdelivr.net/gh/fengyuanchen/cropperjs/dist/cropper.min.js"></script>
<script src="//cdn.jsdelivr.net/gh//fengyuanchen/jquery-cropper/dist/jquery-cropper.min.js"></script>

<script src="//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1/resources/js/main.js"></script>
<script src="//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1/resources/js/admin-field-images-box.js"></script>
<script src="//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1/resources/js/field-relations.js"></script>
<script src="//cdn.jsdelivr.net/gh/NBaskoff/BeetleCore@1/resources/js/relation-table.js"></script>

</body>
</html>
