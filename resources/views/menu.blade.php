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
                <span style="margin-right: 10px;">
                    Добрый день, {{request()->session()->get("admin")->getAttribute("name")}}.
                </span>
            <a href="{{route("admin.exit")}}" class="btn btn-primary">
                <i class="fas fa-sign-out-alt"></i> Выход
            </a>
        </div>
    </div>
</nav>
