<?php

namespace BeetleCore\Actions;

use BeetleCore\Controllers\TableController;
use BeetleCore\Form;

class RelationFormAction
{
    public function __invoke()
    {
        $model = request("model");
        /** @var $model TableController */
        $model = new $model;
        $form = new Form(new $model, null, $model->getFindFields());
        $html = $form->renderFind([]);
        $ids = \request()->get("ids", []);
        if (!empty($ids)) {
            $records = $model::query()->whereIn($model->getKeyName(), $ids)->get([$model->getKeyName(), $model->nameKey])->toArray();
            $ids = [];
            if (!empty($records)) foreach ($records as $k => $i) {
                $ids[] = [
                    "id" => $i[$model->getKeyName()],
                    "name" => $i[$model->nameKey],
                ];
            }
        } else {
            $ids = [];
        }
        return view("beetlecore::relation_form", compact("model", "html", "ids"));
    }
}
