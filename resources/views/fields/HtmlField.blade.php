@if ($action == "find")
    <div class="form-group">
        <label class="col-form-label">{{$class->name}}</label>
        <input name="{{$class->field}}" type="text" class="form-control @if ($class->errors) is-invalid @endif" value="{{$value}}">
        <div class="invalid-feedback invalid-feedback-{{$class->field}}">
            @foreach($class->errors as $k=>$i)
                {{$i}}<br>
            @endforeach
        </div>

    </div>
@else
    <div class="form-group row ">
        <label class="col-md-4 col-form-label">{{$class->name}}</label>
        <div class="col-md-8">
            <textarea name="{{$class->field}}" class="form-control tinymce @if ($class->errors) is-invalid @endif">{{$value}}</textarea>
            <div class="invalid-feedback invalid-feedback-{{$class->field}}">
                @foreach($class->errors as $k=>$i)
                    {{$i}}<br>
                @endforeach
            </div>

        </div>
    </div>
@endif
