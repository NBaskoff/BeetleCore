@extends("beetlecore::body")
@push('title')
    {{$model->modelName}} :: Добавление / Редактирование записи
@endpush
@section('content')
    <div class="card margin-top">
        <div class="card-header">
            {{$model->modelName}} :: Добавление / Редактирование записи
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="system_count_try" value="{{request("system_count_try", 0) + 1}}">
                {{csrf_field()}}
                @foreach($html as $k=>$i)
                    {!! $i !!}
                @endforeach
                <div class="form-group row">
                    <div class="col-md-4">
                        <a href="{{request("back")}}" class="btn btn-back btn-block">Отмена</a>
                    </div>
                    <div class="col-md-8">
                        <button name="system_value__save" value="Y" class="btn btn-primary btn-block">
                            Сохранить
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
