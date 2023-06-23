@if ($action == "find")
    <div class="form-group relation-form-box" data-ignore-id="{{$ignoreId}}" data-multiple="{{$multiple}}" data-field="{{$class->field}}" data-model="{{get_class($model)}}" data-link-self="{{$model->getLinkSelf()}}" data-action="{{$action}}">
        <label class="col-form-label">
            {{$class->name}}
            <span class="relation-add-edit" style="cursor: pointer;">
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
        <div class="invalid-feedback invalid-feedback-{{$class->field}}">
            @foreach($class->errors as $k=>$i)
                {{$i}}<br>
            @endforeach
        </div>
    </div>
@else
    <div class="form-group row">
        <label class="col-md-4 col-form-label">{{$class->name}}</label>
        <div class="col-md-8 relation-form-box" data-ignore-id="{{$ignoreId}}" data-multiple="{{$multiple}}" data-field="{{$class->field}}" data-model="{{get_class($model)}}" data-link-self="{{$model->getLinkSelf()}}" data-action="{{$action}}">
            <div class="form-control" name="{{$class->field}}" style="height: auto;">
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
                <div class="btn btn-primary btn-sm relation-add-edit">Добавить / Удалить</div>
            </div>
            <div class="invalid-feedback invalid-feedback-{{$class->field}}">
                @foreach($class->errors as $k=>$i)
                    {{$i}}<br>
                @endforeach
            </div>
        </div>
    </div>
@endif
