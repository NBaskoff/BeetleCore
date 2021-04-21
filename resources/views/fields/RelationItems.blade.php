<div class="form-group relation-items" data-lines="{{count($html)-1}}" data-replace-copy="{{$class->field}}[|line|]">
    <div class="row form-group">
        <label class="col-md-4 col-form-label">{{$class->name}}</label>
        <div class="col-md-8">
            <div class="relation-items-add btn btn-primary btn-sm">
                Добавить запись
            </div>
        </div>
    </div>
    <div class="relation-items-add-box">
        <div class="card relation-items-box">
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="{{$class->field}}[|line|][id]" value="add">
                    @foreach($htmlAdd as $ik=>$ii)
                        <div class="col-md-6">
                            {!! $ii !!}
                        </div>
                    @endforeach
                </div>
                <div class="delete relation-items-delete">
                    <i class="fas fa-trash"></i>
                </div>

            </div>
        </div>
    </div>
    <div class="items-box">
        @foreach($html as $k=>$i)
            <div class="card relation-items-box">
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="{{$class->field}}[{{$k}}][id]" value="{{$i["id"]}}">
                        @foreach($i["html"] as $ik=>$ii)
                            <div class="col-md-6">
                                {!! $ii !!}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="delete relation-items-delete">
                    <i class="fas fa-trash"></i>
                </div>
            </div>
        @endforeach
    </div>

</div>
