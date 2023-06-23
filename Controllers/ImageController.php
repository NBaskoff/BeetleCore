<?php


namespace BeetleCore\Controllers;

use BeetleCore\Actions\ImageLoadAction;
use BeetleCore\Actions\ImageSizeAction;

class ImageController extends Controller
{
    public function load(ImageLoadAction $action)
    {
        return $action();
    }

    public function size(ImageSizeAction $action)
    {
        return $action();
    }

}
