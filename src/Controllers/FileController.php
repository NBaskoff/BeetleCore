<?php


namespace BeetleCore\Controllers;

use BeetleCore\Actions\FileLoadAction;

class FileController extends Controller
{
    public function load(FileLoadAction $action)
    {
        return $action();
    }
}
