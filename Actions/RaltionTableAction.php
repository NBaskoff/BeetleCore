<?php

namespace BeetleCore\Actions;

use BeetleCore\Controllers\TableController;
use BeetleCore\Form;

class RaltionTableAction
{
    public function __invoke()
    {
        /** @var $model TableController */
        $model = request("model");
        $model = new $model;
        $ids = \request()->get("ids", []);
        $fields = $model->getShowFields();
        $parent = request("parent", 0);
        $find = request()->get("find", []);
        if (!empty($find)) {
            parse_str($find, $find);
        }

        if (empty($find)) {
            if (!empty($model->getLinkSelf())) {
                if (!empty($parent)) {
                    $records = $model->getShowRecords($model->getLinkSelf(), request("parent"));
                } else {
                    $records = $model->getShowRecords(0, 0);
                }
            } else {
                $records = $model->getShowRecords(null, null);
            }
        } else {
            $records = $model->getShowRecords(null, null);
        }

        $form = new Form(new $model);
        if (!empty(request("ignore"))) {
            $records = $records->whereNotIn($model->getKeyName(), explode(",", request("ignore")));
        }
        $records = $form->createFind($records, $find)->paginate(10, ["*"], "page", \request()->get("page", 1));
        $records = $form->renderShow($records);
        $breadCrumbs = [];
        if (!empty($parent)) {
            $record = $model::query()->find($parent);
            $breadCrumbs = $record->getSelfBreadCrumbs();
        }
        return view("beetlecore::relation_table", compact("records", "fields", "ids", "model", "breadCrumbs"));
    }
}
