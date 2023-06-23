<?php


namespace BeetleCore\Controllers;

use BeetleCore\Actions\FormLoadAction;
use BeetleCore\Actions\FormSaveAction;
use BeetleCore\Form as FormBeetle;

class FormController extends Controller
{
    public function load(FormLoadAction $action)
    {
        echo $action();
    }

    public function save(FormSaveAction $action)
    {
        return $action();
    }
}
