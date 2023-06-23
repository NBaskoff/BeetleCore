<?php

namespace BeetleCore\Fields;

use App\Admin\Admin;
use App\Form;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class BasicField
{
    protected static $order = false;
    protected static $search = false;
    protected $default = "";
    /**
     * @var Admin
     */
    protected $record;

    /**
     * Массив проверок
     * @var BeetleCore\Validators\Basic
     */
    protected $validators = [];
    /**
     * @var BeetleCore\Form
     */
    protected $form;
    public $field = "";
    public $name = "";
    public $errors = [];

    public function __construct($field, $params, $record)
    {
        foreach ($params as $k => $i) {
            $this->{$k} = $i;
        }
        $this->field = $field;
        $this->record = $record;
    }

    public function add()
    {
        $data = [];
        if (!empty($this->default)) {
            $data[$this->field] = $this->default;
        }
        return $this->standart($data, "add");
    }

    public function post($data)
    {
        return $this->standart($data, "post");
    }

    public function edit($data)
    {
        return $this->standart($data, "edit");
    }

    public function find($data)
    {
        return $this->standart($data, "find");
    }

    public function save($data)
    {
        if (array_key_exists($this->field, $data)) {
            return [$this->field => trim($data[$this->field])];
        } else {
            return false;
        }

    }

    public function del($data)
    {
        return true;
    }

    public function valid($data)
    {
        $valid = true;
        $value = "";
        if (!empty($data[$this->field])) {
            $value = $data[$this->field];
        }
        if (!empty($this->validators)) foreach ($this->validators as $k => $i) {
            $validator = $this->createValidator($i)->valid($value);
            if ($validator !== true) {
                $valid = false;
                $this->errors[] = $validator;
            }
        }
        return $valid;
    }

    /**
     * @param $params
     * @return \App\Beetle\Validator\Basic
     */
    protected function createValidator($params)
    {
        $values = [];
        if (!empty($params[1])) {
            $values = $params[1];
        }
        return new $params[0]($this->field, $values, $this->record);
    }

    public static function isOrder()
    {
        return static::$order;
    }

    public static function isSearch()
    {
        return static::$search;
    }

    public function createFind(Builder $db, $data)
    {
        if (!empty($data[$this->field])) {
            if (env("DB_CONNECTION") == "pgsql") {
                $db = $db->where($this->field, 'ILIKE', '%' . $data[$this->field] . '%');
            } else {
                $db = $db->where($this->field, 'LIKE', '%' . $data[$this->field] . '%');
            }
        }
        return $db;
    }

    public function show($records)
    {
        return $records;
    }

    protected function standart($data, $action)
    {
        if (!empty($data[$this->field])) {
            $value = $data[$this->field];
        } else {
            $value = $this->default;
        }
        $class = $this;
        return view("beetlecore::fields." . class_basename($this), compact("action", "value", "class"))->toHtml();
    }

    public function getError()
    {
        return $this->errors;
    }

    public function afterSave($data)
    {
        return true;
    }

}
