<!doctype html>
<html lang="ru">
<head>
    @include("beetlecore::head")
</head>
<body>
<!-- Modal Images -->
<div class="modal fade" id="modalCropper" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 999999;">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование изображения</h5>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-image">
                    <img id="image">
                </div>
            </div>
            <div class="modal-footer">
                <div class="docs-buttons">
                    <div class="btn-group">
                        <div class="btn btn-primary zoom-in">
                            <i class="fa fa-search-plus"></i>
                        </div>
                        <div class="btn btn-primary zoom-out">
                            <i class="fa fa-search-minus"></i>
                        </div>
                    </div>

                    <div class="btn-group">
                        <div class="btn btn-primary move-left">
                            <i class="fa fa-arrow-left"></i>
                        </div>
                        <div class="btn btn-primary move-right">
                            <i class="fa fa-arrow-right"></i>
                        </div>
                        <div class="btn btn-primary move-up">
                            <i class="fa fa-arrow-up"></i>
                        </div>
                        <div class="btn btn-primary move-down">
                            <i class="fa fa-arrow-down"></i>
                        </div>
                    </div>

                    <div class="btn-group">
                        <div class="btn btn-primary rotate-left">
                            <i class="fa fa-undo-alt"></i>
                        </div>
                        <div class="btn btn-primary rotate-right">
                            <i class="fa fa-redo-alt"></i>
                        </div>
                    </div>
                    {{--<div class="btn-group">
                        <div class="btn btn-primary ">
                            <i class="fa fa-arrows-alt-h"></i>
                        </div>
                        <div class="btn btn-primary">
                            <i class="fa fa-arrows-alt-v"></i>
                        </div>
                    </div>--}}
                    <div class="btn btn-primary btn-block save">
                        <i class="fa fa-save"></i> Сохранить
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container {{--container-fluid--}}">
    @include("beetlecore::menu")
    @yield("content")
</div>
@include("beetlecore::script")
</body>
</html>
