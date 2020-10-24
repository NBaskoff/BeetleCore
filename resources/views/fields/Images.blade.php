<div class="form-group row">
    <label class="col-md-4 col-form-label">{{$class->name}}@if (!empty($class->desc)) ({{$class->desc}}) @endif</label>
    <div class="col-md-8">
        <div class="admin-field-images-box" data-width="{{$class->width}}" data-height="{{$class->height}}" data-filed="{{$class->field}}">
            <div class="images-list-box">
                <div class="image-box image-load" style="display: none">
                    <div class="image">
                        <img src="{{$beetleCoreResourcesFolder}}/i/6.gif" style="width: 70px;">
                    </div>
                    <div class="name">Загрузка изображения</div>
                </div>
                @foreach($value as $info)
                    @include("beetlecore::fields.image_box_load")
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

