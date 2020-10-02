@extends("beetlecore::body")
@section('title')
    {{$model->modelName}} :: Просмотр записей
@endsection
@section('css')@endsection
@section('js')@endsection
@section('content')
    <div class="card margin-top">
        <div class="card-header">
            <div class="row">
                @if ($id == 0)
                    <div class="col-md-11 card-header-text">
                        {{$model->modelName}} :: Просмотр записей
                    </div>
                @else
                    <div class="col-md-1">
                        <a class="btn btn-primary btn-block btn-sm"
                           href="{{route(request()->route()->getName(), ["action" => "show"])}}">
                            <i class="fas fa-chevron-circle-left"></i>
                        </a>
                    </div>
                    <div class="col-md-10 card-header-text">
                        {{$model->modelName}} :: Просмотр записей
                    </div>
                @endif

                <div class="col-md-1">
                    <a class="btn btn-primary btn-block btn-sm"
                       href="{{route(request()->route()->getName(), ["action" => "add", "parent"=>$parent, "id"=>$id])}}">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="get">
                <div class="row">
                    @foreach($html as $k=>$i)
                        <div class="col-md-4 col-xl-2">
                            {!! $i !!}
                        </div>
                    @endforeach
                    <div class="col-md-4 col-xl-2">
                        <div class="form-group">
                            <label class="col-form-label">&nbsp;</label>
                            <button type="submit" name="find" value="yes"
                                    class="btn btn-primary btn-block startFind">
                                Поиск
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="scroll-box">
                <table class="table table-striped table-hover table-bordered table-sm" id="dataTable">
                    <thead class="thead-color">
                    <tr>
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
                        <th width="100px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($records as $record)
                        @php
                            $recordId = $record->getAttribute($model->getKeyName())
                        @endphp
                        <tr>
                            @if (!empty($model->positionKey))
                                <td style="text-align: center;">
                                    <div class="dragRow" rel="{{$recordId}}"><i class="fas fa-arrows-alt-v"></i>
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
                                        <a href="{{route($link[0], ["action" => "show", "parent"=>$kl, "id"=>$recordId])}}">{{$link[1]}}({{$record->{explode(".", $kl)[0]}()->getQuery()->count()}})</a><br>
                                    @endforeach
                                </td>
                            @endif
                            <td style="text-align: center;">
                                @if (!empty($record->activeKey))
                                    <div class="active-record-box @if ($record->getOriginal($record->activeKey) == "Y") active @endif" data-id="{{$recordId}}">
                                        <i class="fas fa-eye icon-active"></i>
                                        <i class="fas fa-eye-slash icon-disabled"></i>
                                    </div>
                                @endif
                                <a href="{{route(request()->route()->getName(), ["action" => "edit", "parent"=>$parent, "id"=>$id, "record"=>$recordId])}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                &nbsp;&nbsp;
                                <a onclick="return confirm('Удалить запись?')" href="{{route(request()->route()->getName(), ["action" => "del", "parent"=>$parent, "id"=>$id, "record"=>$recordId])}}?back={{$_SERVER["REQUEST_URI"]}}">
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
                    <a class="btn btn-primary btn-block btn-sm"
                       href="{{route(request()->route()->getName(), ["action" => "add", "parent"=>$parent, "id"=>$id])}}">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <div class="col-md-11">

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
