@extends("beetlecore::body")
@section('title')
    Настройки сайта
@endsection
@section('css')@endsection
@section('js')@endsection
@section('content')

    <div class="card margin-top">
        <div class="card-header">
            Настройки сайта
        </div>
        <div class="card-body">
            @if ($save)
                <div class="alert alert-success">
                    Данные сохранены
                </div>
            @endif
            <form method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                @foreach($html as $k=>$i)
                    {!! $i !!}
                @endforeach
                <div class="form-group">
                    <button name="system_value__save" value="Y" class="btn btn-primary btn-block">
                        Сохранить
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
