@if ($action == "find")
    <div class="form-group relation-form-box">
        <label class="col-form-label">
            {{$class->name}}
            <span class="relation-add-edit" data-ignore-id="{{$ignoreId}}" data-multiple="{{$multiple}}" data-field="{{$class->field}}" data-model="{{$model->shotName()}}" style="cursor: pointer;">
                <i class="fas fa-list"></i> <i class="fas fa-search"></i>
            </span>
        </label>
        <div class="relation-ids">
            @foreach($ids as $id)
                <div class="relation-id" data-id="{{$id["id"]}}">
                    <input type="hidden" name="{{$class->field}}[id][]" value="{{$id["id"]}}">
                    {{$id["name"]}}
                    <div class="close">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($class->errors)
            <div class="invalid-feedback">
                @foreach($class->errors as $k=>$i)
                    {{$i}}<br>
                @endforeach
            </div>
        @endif
    </div>
@else
    <div class="form-group row">
        <label class="col-md-4 col-form-label">{{$class->name}}</label>
        <div class="col-md-8 relation-form-box">

            <div class="relation-ids">
                @foreach($ids as $id)
                    <div class="relation-id" data-id="{{$id["id"]}}">
                        <input type="hidden" name="{{$class->field}}[id][]" value="{{$id["id"]}}">
                        {{$id["name"]}}
                        <div class="close">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="btn btn-primary btn-sm relation-add-edit" data-ignore-id="{{$ignoreId}}" data-multiple="{{$multiple}}" data-field="{{$class->field}}" data-model="{{$model->shotName()}}">Добавить / Удалить</div>
        </div>
    </div>
@endif
