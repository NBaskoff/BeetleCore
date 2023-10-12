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
    <div class="form-group row">
        <label class="col-md-4 col-form-label">{{$class->name}}</label>
        <div class="col-md-8 admin-field-files-box">
            <input name="{{$class->field}}" type="hidden" class="form-control @if ($class->errors) is-invalid @endif" value="{{ $value }}">
            <div class="row">
                <div class="empty col-md-3">
                    <div class="btn select-file btn btn-primary btn-sm">Загрузить файл</div>
                </div>
                <div class="status col-md-9">
                    @if (!empty($value))
                        Файл
                        <a href="{{ Storage::url(json_decode($value)->path) }}" target="_blank">{{ json_decode($value)->name }}</a> успешно загружен
                    @endif
                </div>
            </div>
            <div class="invalid-feedback invalid-feedback-{{$class->field}}">
                @foreach($class->errors as $k=>$i)
                    {{$i}}<br>
                @endforeach
            </div>
        </div>
    </div>
@endif
