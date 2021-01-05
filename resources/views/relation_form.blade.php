<div class="container">
    <div class="relation-box">
        <form class="relation-ids">
            @foreach($ids as $id)
                <div class="relation-id" data-id="{{$id["id"]}}">
                    {{$id["name"]}}
                    <div class="close">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            @endforeach
        </form>
        <form class="relation-form">
            <div class="row">
                <input type="hidden" name="relation__find_start" value="Y">
                @foreach($html as $k=>$i)
                    <div class="col-md-4 col-xl-2">
                        {!! $i !!}
                    </div>
                @endforeach
                <div class="col-md-4 col-xl-2">
                    <div class="form-group">
                        <label class="col-form-label">&nbsp;</label>
                        <div class="btn btn-primary btn-block start-find">Поиск</div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-2">
                    <div class="form-group">
                        <label class="col-form-label">&nbsp;</label>
                        <div class="btn btn-back btn-block stop-find">Отмена</div>
                    </div>
                </div>
            </div>
        </form>
        <div class="scroll-box relation-table">

        </div>
    </div>
</div>
