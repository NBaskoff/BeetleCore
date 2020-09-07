<div class="form-group row relation-table" data-lines="{{count($records)-1}}" data-replace-copy="{{$class->field}}[|line|]">
    {{--<label class="">{{$class->name}}</label>--}}
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th style="min-width: 50px"></th>
            @foreach($class->relations as $k=>$i)
                <th>
                    @if (is_array($i))
                        {!! $i["name"] !!}
                    @else
                        {!! $i !!}
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <tr class="relation-table-add-line" style="display: none;">
            <td>
                <input type="hidden" name="{{$class->field}}[|line|][id]" value="new">
                <input type="checkbox" class="relation-row-select" data-replace-copy="{{$class->field}}[|line|]">
                {{--<div class="relation-table-delete-line">
                    <i class="fas fa-trash"></i>
                </div>--}}
            </td>
            @foreach($models as $k=>$i)
                <td>
                    @if (is_array($i))
                        @if ($i["type"] == "Textarea")
                            <textarea name="{{$class->field}}[|line|][{{$k}}]"></textarea>
                        @endif
                        @if ($i["type"] == "Image")
                            <div class="admin-field-images-box" data-width="300" data-height="300" data-filed="{{$class->field}}[|line|][{{$k}}]">
                                <div class="images-list-box">
                                    <div class="image-box image-load" style="display: none">
                                        <div class="image">
                                            <img src="/i/6.gif" style="width: 70px;">
                                        </div>
                                        <div class="name">Загрузка изображения</div>
                                    </div>
                                </div>
                                <div class="select-file btn btn-primary btn-sm">Загрузить изображения</div>
                            </div>
                        @endif
                    @else
                        <div class="relation-form-box">
                            <div class="relation-ids">
                                <div class="relation-id">
                                    {{--<input type="hidden" name="{{$class->field}}[|line|][{{$k}}][id][]" value="0">
                                    <input type="hidden" name="{{$class->field}}[|line|][{{$k}}][id][]" value="0">--}}
                                </div>
                            </div>
                            @if (get_class($model->{$k}()) == "Illuminate\Database\Eloquent\Relations\BelongsToMany")
                                <div class="relation-add-edit" data-multiple="true" data-field="{{$class->field}}[|line|][{{$k}}]" data-model="{{$i->shotName()}}">
                                    <i class="fas fa-edit"></i>
                                </div>
                            @else
                                <div class="relation-add-edit" data-multiple="false" data-field="{{$class->field}}[|line|][{{$k}}]" data-model="{{$i->shotName()}}">
                                    <i class="fas fa-edit"></i>
                                </div>
                            @endif
                        </div>
                    @endif
                </td>
            @endforeach

        </tr>
        @foreach($records as $k=>$i)
            <tr>
                <td>
                    <input type="checkbox" class="relation-row-select" data-replace-copy="{{$class->field}}[{{$k}}]">
                    <input type="hidden" name="{{$class->field}}[{{$k}}][id]" value="{{ $i->{$i->getKeyName()} }}">
                    {{--<div class="relation-table-delete-line">
                        <i class="fas fa-trash"></i>
                    </div>--}}
                </td>
                @foreach($models as $mk=>$mi)
                    <td>
                        @if (is_array($mi))
                            @if ($mi["type"] == "Textarea")
                                <textarea name="{{$class->field}}[{{$k}}][{{$mk}}]">{{$i->$mk}}</textarea>
                            @endif
                            @if ($mi["type"] == "Image")
                                <?php $value = json_decode($i->$mk, true); $field = "$class->field[$k][$mk]"?>
                                <div class="admin-field-images-box" data-width="300" data-height="300" data-filed="{{$class->field}}[{{$k}}][{{$mk}}]">
                                    <div class="images-list-box">
                                        <div class="image-box image-load" style="display: none">
                                            <div class="image">
                                                <img src="/i/6.gif" style="width: 70px;">
                                            </div>
                                            <div class="name">Загрузка изображения</div>
                                        </div>
                                        @if ($value)
                                            @foreach($value as $info)
                                                @include("fields.image_box_load")
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="select-file btn btn-primary btn-sm">Загрузить изображения</div>
                                </div>
                            @endif
                        @else
                            <div class="relation-form-box">
                                <div class="relation-ids">
                                    @if (get_class($i->{$mk}()) == "Illuminate\Database\Eloquent\Relations\BelongsToMany")
                                        @foreach($i->{$mk} as $item)
                                            <div class="relation-id" data-id="{{$item[$mi->getKeyName()]}}">
                                                <input type="hidden" name="{{$class->field}}[{{$k}}][{{$mk}}][id][]" value="{{$item[$mi->getKeyName()]}}">
                                                <input type="hidden" name="{{$class->field}}[{{$k}}][{{$mk}}][name][]" value="{{$item[$item->nameKey]}}">
                                                <div class="close">
                                                    <i class="fas fa-times-circle"></i>
                                                </div>
                                                {{$item[$item->nameKey]}}
                                            </div>
                                        @endforeach
                                    @elseif (!empty($i->{$mk}))
                                        <div class="relation-id" data-id="{{$i->{$mk}[$mi->getKeyName()]}}">
                                            <input type="hidden" name="{{$class->field}}[{{$k}}][{{$mk}}][id][]" value="{{$i->{$mk}[$mi->getKeyName()]}}">
                                            <input type="hidden" name="{{$class->field}}[{{$k}}][{{$mk}}][name][]" value="{{$i->{$mk}[$i->{$mk}->nameKey]}}">
                                            <div class="close">
                                                <i class="fas fa-times-circle"></i>
                                            </div>
                                            {{$i->{$mk}[$i->{$mk}->nameKey]}}
                                        </div>
                                    @endif
                                </div>

                                @if (get_class($model->{$mk}()) == "Illuminate\Database\Eloquent\Relations\BelongsToMany")
                                    <div class="relation-add-edit" data-multiple=true data-field="{{$class->field}}[{{$k}}][{{$mk}}]" data-model="{{$mi->shotName()}}">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                @else
                                    <div class="relation-add-edit" data-multiple=false data-field="{{$class->field}}[{{$k}}][{{$mk}}]" data-model="{{$mi->shotName()}}">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="btn btn-primary relation-table-add" style="margin-right: 15px;">Добавить строку</div>
    <div class="btn btn-primary relation-table-copy" style="margin-right: 15px;">Копировать выбранные</div>
    <div class="btn btn-primary relation-table-del">Удалить выбранные</div>
</div>
