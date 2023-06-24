<div class="form-group row">
    <label class="col-md-4 col-form-label">{{$class->name}}@if (!empty($class->desc)) ({{$class->desc}}) @endif</label>
    <div class="col-md-8">
        <div class="admin-field-images-box {{$class->class ?? ""}}" data-style="{{$class->style ?? ""}}" data-width="{{$class->width ?? 250}}" data-height="{{$class->height ?? 250}}" data-filed="{{$class->field}}">
            <div class="images-list-box">
                <div class="image-box image-load" style="display: none">
                    <div class="image">
                        <img src="/images/vendor/nbaskoff/beetlecore/6.gif" style="width: 70px;">
                    </div>
                    <div class="name">Загрузка изображения</div>
                </div>
                @foreach($value as $info)
                    @include("beetlecore::fields.image_box_load")
                @endforeach
            </div>
            <div class="select-file btn btn-primary btn-sm" >Загрузить изображения</div>
        </div>

        <div class="invalid-feedback invalid-feedback-{{$class->field}}">
            @foreach($class->errors as $k=>$i)
                {{$i}}<br>
            @endforeach
        </div>
    </div>
</div>

