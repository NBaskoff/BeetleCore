<?php


namespace BeetleCore\Controllers;

use BeetleCore\Actions\RaltionTableAction;
use BeetleCore\Actions\RelationFormAction;

class RelationController extends Controller
{

    public function form(RelationFormAction $action)
    {
        return $action();
    }

    public function table(RaltionTableAction $action)
    {
        return $action();
    }
}
