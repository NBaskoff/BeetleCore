@extends("beetlecore::body")
@push('title')
    {{$model->modelName}} :: Просмотр записей
@endpush
@push('js')
    <script src="/js/vendor/nbaskoff/beetlecore/show.js"></script>
@endpush
@section('content')
    <div class="card margin-top">
        <div class="card-header">
            <div class="row">
                <div class="col-md-1" id="history-back" style="display: none">
                    <a class="btn btn-primary btn-block btn-sm" href="/">
                        <i class="fas fa-chevron-circle-left"></i>
                    </a>
                </div>
                <div class="col-md-11 card-header-text" id="page-title">
                    {{$model->modelName}} :: Просмотр записей
                </div>
                <div class="col-md-1">
                    <a class="btn btn-primary btn-block btn-sm back-link" href="{{route(request()->route()->getName(), ["action" => "add", "parent"=>$parent, "parent_id"=>$id, "back"=>$_SERVER["REQUEST_URI"]])}}">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="get" id="main-form">
                <div class="row">
                    @foreach($html as $k=>$i)
                        <div class="col-md-4 col-xl-2">
                            {!! $i !!}
                        </div>
                    @endforeach
                    <div class="col-md-4 col-xl-2">
                        <div class="form-group">
                            <label class="col-form-label">&nbsp;</label>
                            <button type="submit" name="find" value="yes" class="btn btn-primary btn-block startFind">Поиск</button>
                        </div>
                    </div>
                </div>
            </form>
            <form method="get" action="{{route(request()->route()->getName(), ["action" => "bulk", "parent"=>$parent, "id"=>$id])}}">
                <input type="hidden" name="back" value="{{$_SERVER["REQUEST_URI"]}}">
                <div class="scroll-box">
                    <table class="table table-striped table-hover table-bordered table-sm" id="dataTable">
                        <thead class="thead-color">
                        <tr>
                            <th width="30px" style="text-align: center;">
                                <input type="checkbox" class="active-table-checkbox">
                            </th>
                            @if (!empty($model->positionKey))
                                <th width="50px"></th>
                            @endif
                            <th>#</th>
                            @foreach($fields as $field)
                                <th>{{$field["name"]}}</th>
                            @endforeach
                            @if (!empty($model->getLinks()))
                                <th></th>
                            @endif
                            <th width="120px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($records as $record)
                            @php
                                $recordId = $record->getAttribute($model->getKeyName())
                            @endphp
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="records[]" value="{{$recordId}}">
                                </td>
                                @if (!empty($model->positionKey))
                                    <td style="text-align: center;">
                                        <div class="dragRow" data-id="{{$recordId}}"><i class="fas fa-arrows-alt-v"></i>
                                        </div>
                                    </td>
                                @endif
                                <td>{{$recordId}}</td>
                                @foreach($fields as $kf=>$field)
                                    <td>{!! $record->getAttribute($kf) !!}</td>
                                @endforeach
                                @if (!empty($model->getLinks()))
                                    <td>
                                        @foreach($model->getLinks() as $kl=>$link)
                                            <a href="{{route($link[0], ["action" => "show", "parent"=>$kl, "parent_id"=>$recordId])}}">{{$link[1]}} ({{$record->{explode(".", $kl)[0]}()->getQuery()->count()}})</a>
                                            <br>
                                        @endforeach
                                    </td>
                                @endif
                                <td style="text-align: center;">
                                    @if (!empty($record->activeKey))
                                        <span class="active-record-box @if ($record->getOriginal($record->activeKey) == "Y") active @endif" data-id="{{$recordId}}">
                                        <i class="fas fa-eye icon-active"></i>
                                        <i class="fas fa-eye-slash icon-disabled"></i>
                                    </span>
                                        &nbsp;&nbsp;
                                    @endif
                                    <a class="back-link" href="{{route(request()->route()->getName(), ["action" => "edit", "parent"=>$parent, "parent_id"=>$id, "record_id"=>$recordId, "back"=>$_SERVER["REQUEST_URI"]])}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    &nbsp;&nbsp;
                                    <a class="back-link" data-question="Удалить запись?" href="{{route(request()->route()->getName(), ["action" => "del", "parent"=>$parent, "parent_id"=>$id, "record_id"=>$recordId, "back"=>$_SERVER["REQUEST_URI"]])}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <a class="btn btn-primary btn-block btn-sm back-link" href="{{route(request()->route()->getName(), ["action" => "add", "parent"=>$parent, "parent_id"=>$id, "back"=>$_SERVER["REQUEST_URI"]])}}"><i class="fas fa-plus"></i></a>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" name="action" value="edit" class="btn btn-primary btn-block btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" name="action" value="del" data-question="Удалить все выбранные записи?" class="btn btn-primary btn-block btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <div class="col-md-9">
                        <nav>
                            <ul class="pagination justify-content-end">
                                {{ $records->appends(request()->all())->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
        </div>
    </div>
@endsection
