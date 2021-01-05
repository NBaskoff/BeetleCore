<?php


namespace BeetleCore\Controllers;

use \BeetleCore\Form as FormBeetle;

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
            $html = $form->renderEdit($record);
        } else {
            if (!empty($parent)) {
                $filed = explode(".", $parent)[1];
                $record = new $model([$model->{$filed}()->getForeignKeyName() => $parentId]);
            } else {
                $record = new $model();
            }
            $form = new FormBeetle($record);
            $html = $form->renderAdd();
        }

        echo implode("\n", $html).'<div class="form-group row">
                    <div class="col-md-4">
                        <div class="btn btn-back btn-block" data-dismiss="modal">Отмена</div>
                    </div>
                    <div class="col-md-8">
                        <button name="system_value__save" value="Y" class="btn btn-primary btn-block">
                            Сохранить
                        </button>
                    </div>
                </div>';
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