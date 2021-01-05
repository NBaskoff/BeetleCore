<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-8">
        <label>
            <input name="{{$class->field}}" type="checkbox" class="@if ($class->errors) is-invalid @endif" value="Y" @if($value == "Y") checked @endif> {{$class->name}}
        </label>
        <div class="invalid-feedback invalid-feedback-{{$class->field}}">
            @foreach($class->errors as $k=>$i)
                {{$i}}<br>
            @endforeach
        </div>
    </div>
</div>

