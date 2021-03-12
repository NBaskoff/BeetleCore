@foreach($html as $k=>$i)
    {!! $i !!}
@endforeach
<div class="form-group row">
    <div class="col-md-4">
        <div class="btn btn-back btn-block" data-dismiss="modal">Отмена</div>
    </div>
    <div class="col-md-8">
        <button name="system_value__save" value="Y" class="btn btn-primary btn-block">
            Сохранить
        </button>
    </div>
</div>
