@extends("admin.body")
@section('title')
    {{$model->name}} :: Добавление / Редактирование записи
@endsection
@section('css')@endsection
@section('js')@endsection
@section('content')

        <div class="card margin-top">
            <div class="card-header">
                {{$model->name}} :: Добавление / Редактирование записи
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="count_try" value="{{($_POST["count_try"] ?? 0) + 1}}">
                    {{csrf_field()}}
                    @foreach($html as $k=>$i)
                        {!! $i !!}
                    @endforeach
                    <div class="form-group row">
                        <div class="col-md-4">
                            <a onclick="javascript:history.go(-{{($_POST["count_try"] ?? 0) + 1 }}); return false;"
                               class="btn btn-back btn-block">Отмена</a>
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
