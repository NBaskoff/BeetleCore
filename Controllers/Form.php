<?php


namespace BeetleCore\Controllers;

use BeetleCore\Form as FormBeetle;

class Form
{
    public function load()
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
        echo view("beetlecore::form", compact("html", "tabs"))->toHtml();
    }

    public function save()
    {
        $recordId = request("system.recordId");
        $parent = request("system.parent");
        $parentId = request("system.parentId");
        /** @var \BeetleCore\Models\Table $model */
        $model = request("system.modelName");
        $model = new $model;

        $error = null;

        if (!empty($recordId)) {
            $record = $model::query()->find($recordId);
            $form = new \BeetleCore\Form($record);
        } else {
            $record = new $model();
            $form = new \BeetleCore\Form($record);
        }

        $recordName = "";
        if ($form->valid(request()->toArray()) === true) {
            //$this->addEditBeforeSave($parent, $parentId, $recordId);
            $record = $form->save(request()->toArray(), $parent, $parentId);
            $recordId = $record->getAttribute($record->getKeyName());
            $recordName = $record->getAttribute($record->nameKey);
        } else {
            $error = $form->getError();
        }
        return json_encode(compact("error", "recordId", "recordName"));
    }
}
