<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fengyuanchen/cropperjs/dist/cropper.min.css" crossorigin="anonymous">
    {{--<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/harvesthq/chosen-package/chosen.min.css">--}}
    <link rel="stylesheet" href="{{$beetleCoreResourcesFolder}}/css/styles.css">
    @stack('css')
    <title>@stack('title') :: BeetleCMS</title>
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

<script src="//cdn.jsdelivr.net/gh/jquery/jquery/dist/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="{{$beetleCoreResourcesFolder}}/tinymce/tinymce.min.js"></script>
<script src="{{$beetleCoreResourcesFolder}}/tinymce/jquery.tinymce.min.js"></script>

<script src="{{$beetleCoreResourcesFolder}}/js/jquery.tablednd.0.5.js"></script>

{{--<script src="//cdn.jsdelivr.net/gh/harvesthq/chosen-package/chosen.jquery.min.js"></script>--}}

<script src="//cdn.jsdelivr.net/gh/fengyuanchen/cropperjs/dist/cropper.min.js"></script>
<script src="//cdn.jsdelivr.net/gh/fengyuanchen/jquery-cropper/dist/jquery-cropper.min.js"></script>

<script src="{{$beetleCoreResourcesFolder}}/js/urls.js"></script>

<script src="{{$beetleCoreResourcesFolder}}/js/images-box.js"></script>
<script src="{{$beetleCoreResourcesFolder}}/js/relation-field.js"></script>
<script src="{{$beetleCoreResourcesFolder}}/js/relation-table.js"></script>
<script src="{{$beetleCoreResourcesFolder}}/js/relation-items.js"></script>

<script src="//cdn.jsdelivr.net/gh/jquery-form/form/dist/jquery.form.min.js"></script>
<script src="{{$beetleCoreResourcesFolder}}/js/start-form.js"></script>
<script src="{{$beetleCoreResourcesFolder}}/js/ajax-form.js"></script>

<script src="{{$beetleCoreResourcesFolder}}/js/main.js"></script>
@stack('js')

</body>
</html>
