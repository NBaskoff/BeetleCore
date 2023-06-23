<?php

namespace BeetleCore\Actions;

use BeetleCore\Form as FormBeetle;

class FormLoadAction
{
    public function __invoke()
    {
        $recordId = request("recordId");
        $parent = request("parent");
        $parentId = request("parentId");
        /** @var \BeetleCore\Models\Table $model */
        $model = request("modelName");
        $model = new $model;

        if (!empty($recordId)) {
            $record = $model::query()->find($recordId);
            $form = new FormBeetle($record);
        } else {
            if (!empty($parent)) {
                $filed = explode(".", $parent)[1];
                $record = new $model([$model->{$filed}()->getForeignKeyName() => $parentId]);
            } else {
                $record = new $model();
            }
        }
        $fields = $record->getFields();
        $form = new FormBeetle($record, null, $fields);
        if (!empty($recordId)) {
            $html = $form->renderEdit($record);
        } else {
            $html = $form->renderAdd();
        }
        $tabs = [];
        foreach ($fields as $k => $i) {
            if (!empty($i["tab"])) {
                $tabs[$i["tab"]][] = $k;
            } else {
                $tabs["Главная"][] = $k;
            }
        }
        return view("beetlecore::form", compact("html", "tabs"))->toHtml();
    }
}