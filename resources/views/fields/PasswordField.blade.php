
    <div class="form-group row">
        <label class="col-md-4 col-form-label">{{$class->name}}</label>
        <div class="col-md-8">
            <label>
                <input type="checkbox" name="{{$class->field}}_edit" value="Y"> Изменить пароль
            </label>
            <input name="{{$class->field}}" type="text" class="form-control @if ($class->errors) is-invalid @endif" value="" placeholder="Новый пароль">
            <div class="invalid-feedback invalid-feedback-{{$class->field}}">
                @foreach($class->errors as $k=>$i)
                    {{$i}}<br>
                @endforeach
            </div>
        </div>
    </div>

