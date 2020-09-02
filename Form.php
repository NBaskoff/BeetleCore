<?php

namespace BeetleCore;

use BeetleCore\Fields\Basic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Form
{

    /**
     * Массив полей
     * @var \BeetleCore\Fields\Basic[]
     */
    protected $fields;
    /**
     * @var \BeetleCore\Model\Table
     */
    public $record;
    protected $theme = "fields";

    public function __construct(\BeetleCore\Model\Table $record, $theme = "fields")
    {
        $this->record = $record;
        $fields = $record->getFields();
        if (!empty($fields))
            foreach ($fields as $k => $i) {
                $i["form"] = &$this;
                $this->fields[] = new $i["type"]($k, $i, $record);
            }
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function renderAdd()
    {
        $html = [];
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                $html[] = $i->add();
            }
        return $html;
    }

    public function renderEdit($record)
    {
        $html = [];
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                $html[] = $i->edit($record);
            }
        return $html;
    }

    public function renderPost($request)
    {
        $html = [];
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                $html[] = $i->post($request);
            }
        return $html;
    }

    public function renderFind($data)
    {
        $html = [];
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                if ($i::isSearch()) {
                    $html[] = $i->find($data);
                }

            }
        return $html;
    }

    /**
     * @param Builder $db
     * @param $data
     * @return Builder
     */
    public function createFind(Builder $db, $data)
    {
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                $db = $i->createFind($db, $data);
            }
        return $db;
    }

    public function renderShow($records)
    {
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                $records = $i->show($records);
            }
        return $records;
    }

    public function valid($data)
    {
        $valid = true;
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                if (!$i->valid($data)) {
                    $valid = false;
                }
            }
        return $valid;
    }

    public function save($data, $parent, $id)
    {
        $save = [];
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                $value = $i->save($data);
                if ($value !== false) {
                    $save = array_merge($save, $value);
                }
            }

        if (empty($this->record->getAttribute($this->record->getKeyName()))) {
            if (!empty($this->record->positionKey)) {
                $save[$this->record->positionKey] = $this->record::query()->max($this->record->positionKey) + 1;
            }
            if (!empty($parent)) {
                $explodeParent = explode(".", $parent);
                $parentModel = $this->record->{$explodeParent[0]}()->getRelated();
                $parentModel::find($id)->{$explodeParent[1]}()->create($save);
            } else {
                $this->record->fill($save)->save();
            }
        } else {
            $this->record->fill($save)->save();
        }

        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                $i->afterSave($data);
            }
        return $this->record;
    }

    public function getError()
    {
        $error = [];
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                $error[$k] = $i->getError();
            }
        return $error;
    }

    public function getSave($data)
    {
        $save = [];
        if (!empty($this->fields))
            foreach ($this->fields as $k => $i) {
                $value = $i->save($data);
                if ($value !== false) {
                    $save = array_merge($save, $value);
                }
            }
        return $save;
    }
}
