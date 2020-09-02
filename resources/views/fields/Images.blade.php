<div class="modal fade" id="modalCropper" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog {{--modal-xl--}} modal-lg modal-dialog-centered" role="document">
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

<div class="form-group row">
    <label class="col-md-4 col-form-label">{{$class->name}}@if (!empty($class->desc)) ({{$class->desc}}) @endif</label>
    <div class="col-md-8">
        <div class="admin-field-images-box" data-width="{{$class->width}}" data-height="{{$class->height}}" data-filed="{{$class->field}}">
            <div class="images-list-box">

                <div class="image-box image-load" style="display: none">
                    <div class="image">
                        <img src="/admin/i/6.gif" style="width: 70px;">
                    </div>
                    <div class="name">Загрузка изображения</div>
                </div>

                @foreach($value as $info)
                    @include("fields.image_box_load")
                @endforeach
            </div>
            <div class="select-file btn btn-primary btn-sm" >Загрузить изображения</div>
        </div>

        {{--<input name="{{$class->field}}" type="text" class="form-control @if ($class->errors) is-invalid @endif"
               value="{{$value}}">--}}
        @if ($class->errors)
            <div class="invalid-feedback">
                @foreach($class->errors as $k=>$i)
                    {{$i}}<br>
                @endforeach
            </div>
        @endif
    </div>
</div>

