<?php


namespace BeetleCore\Controllers;

use BeetleCore\Actions\ImageLoadAction;
use BeetleCore\Actions\ImageSizeAction;

class ImageController extends Controller
{
    public function load(ImageLoadAction $action)
    {
        return view("beetlecore::fields.image_box_load", $action())->toHtml();
    }

    public function size(ImageSizeAction $action)
    {
        return view("beetlecore::fields.image_box_load", $action())->toHtml();
    }

}
