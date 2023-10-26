@if ($action == "find")
    <div class="form-group">
        <label class="col-form-label">{{$class->name}}</label>
        <select name="{{$class->field}}" class="form-control @if ($class->errors) is-invalid @endif">
            <option value=""></option>
            @foreach($records as $k=>$i)
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
        <label class="col-md-4 col-form-label">{{ $class->name }}</label>
        <div class="col-md-8">
            <div class="admin-field-location-vk-box">
                <div class="control-box country-box">
                    <div class="col-form-label">Страна</div>
                    <select name="country_id" class="form-control country-select @if ($class->errors) is-invalid @endif">
                        {{--<option value=""></option>--}}
                        @foreach($countries->items as $k=>$i)
                            <option value="{{$i->id}}" @if($i->id == $value->country->id) selected @endif>{{$i->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="control-box city-box">
                    <div class="col-form-label">Город</div>
                    <div class="city-load-box">
                        <input class="form-control city-find" placeholder="Начните вводить для поиска города">
                        <img class="load-progress" src="/images/vendor/nbaskoff/beetlecore/6.gif">
                    </div>
                </div>
                <div class="control-box text-box" style="width: 100%;">
                    <div class="text">
                        Страна: <span class="country-text">{{$value->country->title}}</span>,
                        Город: <span class="city-text">{{$value->city->title}}</span><br>
                        <span class="clear-select">Очистить <i class="fas fa-broom"></i></span>
                    </div>
                    <input type="hidden" name="country_title" value="{{$value->country->title}}">
                    <input type="hidden" name="city_id" value="{{$value->city->id}}">
                    <input type="hidden" name="city_title" value="{{$value->city->title}}">
                </div>
            </div>
        </div>
    </div>
@endif
