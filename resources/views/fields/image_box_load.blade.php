<div class="image-box" data-file="{{$info["file"]}}" data-name="{{$info["name"]}}">
    <div class="image">
        <img src="{{$info["small"]}}">
    </div>
    <div class="name">
        {{$info["name"]}}
    </div>
    <div class="del">
        <i class="fa-solid fa-trash"></i>
    </div>
    <div class="edit">
        <i class="fa-solid fa-pen-to-square"></i>
    </div>
    <input type="hidden" name="{{$field}}[]" value="{{json_encode($info)}}">
</div>
