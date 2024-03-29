<?php


namespace BeetleCore\Fields;


use BeetleCore\Models\Table;
use Illuminate\Database\Eloquent\Builder;

class RelationField extends BasicField
{
    protected static $search = true;
    protected $ignore = [];

    public function save($data)
    {
        if (get_class($this->record->{$this->field}()) == "Illuminate\Database\Eloquent\Relations\BelongsTo") {
            return [$this->record->{$this->field}()->getForeignKeyName() => $data[$this->field]["id"][0] ?? 0];
        } elseif (get_class($this->record->{$this->field}()) == "Illuminate\Database\Eloquent\Relations\HasOne") {
            return [$this->record->{$this->field}()->getLocalKeyName() => $data[$this->field]["id"][0] ?? 0];
        } else {
            return false;
        }
    }

    public function afterSave($data)
    {
        if (get_class($this->form->record->{$this->field}()) == "Illuminate\Database\Eloquent\Relations\BelongsToMany") {
            if (!empty($data[$this->field])) {
                $this->form->record->{$this->field}()->sync($data[$this->field]["id"]);
            } else {
                $this->form->record->{$this->field}()->sync([]);
            }
        }
    }

    public function show($records)
    {
        foreach ($records as $k=>$i) {
            if (!empty($i[$this->field])) {
                $nameKey = $i->{$this->field}()->getRelated()->nameKey;
                $value = $i->{$this->field}()->getQuery()->pluck($nameKey)->toArray();
                $records[$k][$this->field] = implode(", ", $value);
            }
        }
        return $records;
    }

    protected function standart($data, $action)
    {
        $ignoreId = [];
        $multiple = false;
        if (get_class($this->form->record->{$this->field}()) == "Illuminate\Database\Eloquent\Relations\BelongsToMany") {
            $multiple = true;
        }
        /** @var $model Table */
        $model = $this->form->record->{$this->field}()->getRelated();
        $primaryKey = $model->getKeyName();
        $nameKey = $model->nameKey;
        $value = "";
        if ($action == "find") {
            $value = "";
            if (!empty($data[$this->field])) {
                $value = $data[$this->field]["id"];
            }
        } elseif ($action == "post") {
            if (!empty($data[$this->field])) {
                $value = $data[$this->field]["id"];
            }
        } else {
            if (get_class($this->form->record->{$this->field}()) == "Illuminate\Database\Eloquent\Relations\BelongsToMany") {
                $value = $this->form->record->{$this->field}()->getQuery()->pluck("{$model->getTable()}.$primaryKey")->toArray();
            } elseif (get_class($this->form->record->{$this->field}()) == "Illuminate\Database\Eloquent\Relations\HasOne") {
                $value = [$this->form->record->getAttribute($this->record->{$this->field}()->getLocalKeyName())];
            } else {
                $value = [$this->form->record->getAttribute($this->record->{$this->field}()->getForeignKeyName())];
            }
        }

        $ids = [];
        if (!empty($value)) {
            $records = $model::query()->whereIn($primaryKey, $value)->get([$primaryKey, $nameKey])->toArray();
            $ids = [];
            if (!empty($records)) foreach ($records as $k => $i) {
                $ids[] = [
                    "id" => $i[$primaryKey],
                    "name" => $i[$nameKey],
                ];
            }
        }
        if (get_class($model) == get_class($this->form->record)) {
            if (!empty($model->getLinkSelf())) {
                if (!empty($this->form->record->getAttribute($primaryKey))) {
                    $ignoreId = $this->form->record->getSelfChildId();
                }
            } else {
                $ignoreId = [$this->form->record->getAttribute($primaryKey)];
            }
        }
        $ignoreId = implode(",", array_merge($ignoreId, $this->ignore));
        $class = $this;
        return view($this->viewPath . class_basename($this), compact("action", "ids", "class", "primaryKey", "nameKey", "multiple", "model", "ignoreId"))->toHtml();
    }

    public function createFind(Builder $db, $data)
    {
        if (!empty($data[$this->field])) {
            $key = $this->record->{$this->field}()->getRelated()->getKeyName();
            $ids = $data[$this->field];
            $db = $db->whereHas($this->field, function ($query) use ($key, $ids) {
                $query->whereIn($key, $ids);
            });
        }
        return $db;
    }
}
