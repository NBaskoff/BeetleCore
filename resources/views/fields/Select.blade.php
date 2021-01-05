@if ($action == "find")
	<div class="form-group">
		<label class="col-form-label">{{$class->name}}</label>
		<select name="{{$class->field}}" class="form-control @if ($class->errors) is-invalid @endif">
			<option value=""></option>
			@foreach($class->data as $k=>$i)
				<option value="{{$k}}" @if($k == $value) selected @endif>{{$i}}</option>
			@endforeach
		</select>
        <div class="invalid-feedback invalid-feedback-{{$class->field}}">
            @foreach($class->errors as $k=>$i)
                {{$i}}<br>
            @endforeach
        </div>
	</div>
@else
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{$class->name}}</label>
		<div class="col-md-8">
			<select name="{{$class->field}}" class="form-control @if ($class->errors) is-invalid @endif">
				<option value=""></option>
				@foreach($class->data as $k=>$i)
					<option value="{{$k}}" @if($k == $value) selected @endif>{{$i}}</option>
				@endforeach
			</select>
            <div class="invalid-feedback invalid-feedback-{{$class->field}}">
                @foreach($class->errors as $k=>$i)
                    {{$i}}<br>
                @endforeach
            </div>
		</div>
	</div>
@endif
