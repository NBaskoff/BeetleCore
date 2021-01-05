@extends("beetlecore::body")
@push('title')
    @if ($record_id)
        {{$model->modelName}} :: Редактирование записи
    @else
        {{$model->modelName}} :: Добавление записи
    @endif
@endpush
@section('content')
    <div class="card margin-top">
        <div class="card-header">
            @if ($record_id)
                {{$model->modelName}} :: Редактирование записи
            @else
                {{$model->modelName}} :: Добавление записи
            @endif
        </div>
        <div class="card-body">
            <form class="ajax-form ajax-form-load" data-model="{{$modelName}}" data-id="{{$record_id}}" data-parent="{{$parent}}" data-parent-id="{{$parent_id}}" data-back="{{$back}}" method="POST" enctype="multipart/form-data">


            </form>
        </div>
    </div>
@endsection
