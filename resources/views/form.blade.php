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

