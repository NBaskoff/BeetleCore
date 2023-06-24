<?php


namespace BeetleCore\Fields;


use BeetleCore\Form;
use BeetleCore\Models\Table;

class RelationItemsField extends BasicField
{
    protected static $search = false;

    protected function standart($data, $action)
    {
        /** @var $model Table узнаем на какую модель ссылается жта связь */
        $model = $this->record->{$this->field}()->getRelated();
        //Выберем все записи //$records = $this->record->{$this->field}()->getQuery()->orderBy($model->getKeyName())->get();
        $records = $this->record->{$this->field}()->getQuery()->get();
        $fields = $model->getFields();
        //Создадим формы для работы с элементами
        $html = [];
        foreach ($records as $k => $i) {
            //$fields = $i->getFields();
            $fieldsThis = [];
            foreach ($fields as $fk => $fi) {
                $key = "$this->field[$k][$fk]";
                $fieldsThis[$key] = $fi;
                $i->setAttribute($key, $i->getAttribute($fk));
            }
            $form = new Form($i, null, $fieldsThis);
            $html[] = [
                "id" => $i->getAttribute($model->getKeyName()),
                "html" => $form->renderEdit()
            ];
        }
        $htmlAdd = [];
        $fieldsThis = [];
        foreach ($fields as $fk => $fi) {
            $key = "$this->field[|line|][$fk]";
            $fieldsThis[$key] = $fi;
        }
        $form = new Form($model, null, $fieldsThis);
        $htmlAdd = $form->renderAdd();
        $class = $this;
        return view($this->viewPath . class_basename($this), compact("action", "class", "html", "htmlAdd"))->toHtml();
    }

    public function save($data)
    {
        return false;
    }

    public function afterSave($data)
    {
        /** @var $model Table узнаем на какую модель ссылается жта связь */
        $model = $this->record->{$this->field}()->getRelated();
        if (!empty($data[$this->field])) {
            unset($data[$this->field]["|line|"]);
            $ids = $this->record->{$this->field}()->getQuery()->pluck($model->getKeyName(), $model->getKeyName());
            foreach ($data[$this->field] as $k=>$i) {
                if ($i["id"] == "add") {
                    $save = [];
                    if (!empty($model->positionKey)) {
                        $save[$model->positionKey] = $model::query()->max($model->positionKey) + 1;
                    }
                    if (!empty($model->activeKey)) {
                        $save[$model->activeKey] = "Y";
                    }
                    $record = $this->record->{$this->field}()->create($save);
                } else {
                    $record = $this->record->{$this->field}()->getQuery()->find($i["id"]);
                    unset($ids[$i["id"]]);
                }
                $form = new Form($record);
                unset($i["id"]);
                $form->save($i);
            }
            $this->record->{$this->field}()->getQuery()->whereIn($model->getKeyName(), $ids)->delete();
        }
    }
}
