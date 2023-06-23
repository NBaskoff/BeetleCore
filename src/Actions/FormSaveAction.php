<?php

namespace BeetleCore\Actions;

class FormSaveAction
{
    public function __invoke()
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