@if (!empty($model->getLinkSelf()))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a class="relation-next-level" data-id="0" href="#">Корень</a>
            </li>
            @foreach($breadCrumbs as $k=>$i)
                <li class="breadcrumb-item">
                    <a class="relation-next-level" data-id="{{$i["id"]}}" href="#">{{$i["name"]}}</a>
                </li>
            @endforeach
        </ol>
    </nav>
@endif
<table class="table table-striped table-hover table-bordered table-sm" id="relationTable">
    <thead class="thead-color">
    <tr>
        <th width="50px"></th>
        <th>#</th>
        @foreach($fields as $field)
            <th>{{$field["name"]}}</th>
        @endforeach
        @if (!empty($model->getLinkSelf()))
            <th></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach ($records as $record)
        @php
            $recordId = $record->getAttribute($model->getKeyName())
        @endphp
        <tr>
            <td style="text-align: center;">
                <input type="checkbox" class="relation-select-input"
                       value="{{$recordId}}"
                       data-name="{{$record->getAttribute($model->field_name)}}"
                       @if(in_array($recordId, $ids)) checked="1" @endif
                >
            </td>
            <td class="relation-select">{{$recordId}}</td>
            @foreach($fields as $kf=>$field)
                <td class="relation-select">{!! $record->getAttribute($kf) !!} </td>
            @endforeach
            @if (!empty($model->getLinkSelf()))
                <td>
                    @php
                        $kl = $model->getLinkSelf();
                        $link =  $model->getLinks()[$kl];
                    @endphp
                    <span class="relation-next-level" data-id="{{$recordId}}">{{$link[1]}} ({{$record->{explode(".", $kl)[1]}()->getQuery()->count()}})</span>
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
<nav>
    <ul class="pagination justify-content-end">
        <!--<li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>-->
        @for($i = 1; $i <= $records->lastPage(); $i++)
            <li class="page-item @if($i ==  $records->currentPage()) active @endif">
                <a class="page-link" href="#">{{$i}}</a>
            </li>
    @endfor
    <!--<li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>-->
    </ul>
</nav>
