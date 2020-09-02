<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-8">
        <label>
            <input name="{{$class->field}}" type="checkbox" class="@if ($class->errors) is-invalid @endif" value="Y" @if($value == "Y") checked @endif> {{$class->name}}
        </label>
        @if ($class->errors)
            <div class="invalid-feedback">
                @foreach($class->errors as $k=>$i)
                    {{$i}}<br>
                @endforeach
            </div>
        @endif
    </div>
</div>

