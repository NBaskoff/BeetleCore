<?php

namespace BeetleCore\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{

    /** @var string Название модуля */
    public $modelName = "";
    /** @var string Описание модуля */
    public $modelDescription = "";
    /** @var string поле где содерджится имя записи */
    public $nameKey = "name";
    /** @var string поле для определания позиции */
    public $positionKey = "";
    /** @var string поле для определания активности*/
    public $activeKey = "";
    /** @var string сортировка по полю */
    public $orderKey = "";

    protected $fields = [];
    protected $relations = [];
    protected $links = [];
    protected $linkSelf = "";
    protected $guarded = []; //чтобы можно было заполнять поля

    protected $loadKey = "img"; //Поле картинки для автозагрузки

    public function getFields()
    {
        return $this->fields;
    }

    public function getFindFields()
    {
        $fields = $this->getFields();
        if (!empty($fields)) foreach ($fields as $k => $field) {
            if (isset($field["find"]) and $field["find"] === false) {
                unset($fields[$k]);
            }
        }
        return $fields;
    }

    public function getShowFields()
    {
        $fields = $this->getFields();
        if (!empty($fields)) foreach ($fields as $k => $field) {
            if (isset($field["show"]) and $field["show"] === false) {
                unset($fields[$k]);
            }
        }
        return $fields;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function dragAndDrop($data)
    {
        $ids = [];
        if (!empty($data)) {
            foreach ($data as $k => $i) {
                $ids[] = $i[0];
            }
            $positions = static::query()->whereIn($this->primaryKey, $ids)->pluck($this->positionKey, $this->primaryKey)->toArray();
            foreach ($data as $k => $i) {
                static::find((int)$i[0])->update([$this->positionKey => $positions[(int)$i[1]]]);
            }
        }
    }

    public function getShowRecords($parent, $id)
    {
        $records = $this::query();
        if (!empty($parent)) {
            $explodeParent = explode(".", $parent);
            $parentModel = $this->{$explodeParent[1]}()->getRelated();
            $ids = $parentModel::find($id)->{$explodeParent[0]}()->getQuery()->pluck($this->getTable() . "." . $this->getKeyName());
            $records = $records->whereIn($this->getKeyName(), $ids);
        }
        if (isset($parent) and !empty($this->linkSelf)) {
            $explodeParent = explode(".", $this->linkSelf);
            $records = $records->where($this->{$explodeParent[0]}()->getForeignKeyName(), $id);
        }
        if (!empty($this->positionKey)) {
            $records = $records->orderBy($this->positionKey);
        }
        if (!empty($this->orderKey)) {
            if (is_array($this->orderKey)) {
                $records = $records->orderBy($this->orderKey[0], $this->orderKey[1] ?? "asc");
            } else {
                $records = $records->orderBy($this->orderKey);
            }
        }
        return $records;
    }

    public function getLinkSelf()
    {
        return $this->linkSelf;
    }

    public function getLoadKey()
    {
        return $this->loadKey;
    }

    public function del()
    {
        if (!empty($this->linkSelf)) {
            $link = explode(".", $this->linkSelf);
            $ids = $this->{$link[0]}()->getQuery()->get($this->getKeyName());
            foreach ($ids as $k => $i) {
                $i->del();
            }
        }
        $this->delete();
    }

    public function getSelfChildId()
    {
        $ids = [$this->getAttribute($this->getKeyName())];
        if (!empty($this->linkSelf)) {
            $link = explode(".", $this->linkSelf);
            $child = $this->{$link[0]};
            foreach ($child as $k => $i) {
                $ids = array_merge($ids, $i->getSelfChildId());
            }
        }
        return $ids;
    }

    public function getSelfBreadCrumbs()
    {
        $breadCrumb = [];
        if (!empty($this->linkSelf)) {
            $link = explode(".", $this->linkSelf);
            $breadCrumb[] = ["id" => $this->getAttribute($this->getKeyName()), "name" => $this->getAttribute($this->nameKey)];
            $parent = $this->{$link[1]};
            if (!empty($parent)) {
                $breadCrumb = array_merge($parent->getSelfBreadCrumbs(), $breadCrumb);
            }
        }
        return $breadCrumb;
    }

    public function active($id, $value)
    {
        static::query()->find($id)->update([$this->activeKey => $value]);
        return $value;
    }

    /**
     * Добавляет к запросу проверку на активность и выстраивает по позиции
     * @param string $active Значение поля активности (Y, N, 1, 0)
     * @param string $order Сортировка по позиции (asc, desc)
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query($active = null, $order = null)
    {
        $model = new static();
        $query = parent::query();
        if (!empty($model->activeKey) and !empty($active)) {
            $query = $query->where($model->activeKey, $active);
        }
        if (!empty($order)) {
            if (!empty($model->positionKey)) {
                $query = $query->orderBy($model->positionKey, $order);
            }
            if (!empty($model->orderKey)) {
                $query = $query->orderBy($model->orderKey, $order);
            }
        }
        return $query;
    }
}
