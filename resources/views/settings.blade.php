@extends("beetlecore::body")
@push('title')
    Настройки сайта
@endpush
@section('content')



    <div class="card margin-top">
        <div class="card-header">
            {{$model->modelName}}
        </div>
        <div class="card-body">
            @if ($save)
                <div class="alert alert-success">
                    Данные сохранены
                </div>
            @endif
            <form method="POST" id="main-form" enctype="multipart/form-data">
                {{csrf_field()}}
                @if (count($tabs) > 1)
                    <div class="beetle-tab">
                        <ul class="nav nav-tabs">
                            @php($count = 0)
                            @foreach($tabs as $kt=>$it)
                                <li class="nav-item">
                                    <a class="nav-link @if($count == 0) active @endif" href="#beetle-tab{{$count}}">
                                        {{$kt}}
                                    </a>
                                </li>
                                @php($count = $count + 1)
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @php($count = 0)
                            @foreach($tabs as $kt=>$it)
                                <div class="tab-pane @if($count == 0) active @endif" id="beetle-tab{{$count}}">
                                    @foreach($it as $k=>$i)
                                        {!! $html[$i] !!}
                                    @endforeach
                                </div>
                                @php($count = $count + 1)
                            @endforeach
                        </div>
                    </div>
                @else
                    @foreach($html as $k=>$i)
                        {!! $i !!}
                    @endforeach
                @endif
                <div class="form-group">
                    <button name="system_value__save" value="Y" class="btn btn-primary btn-block">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
