<?php

namespace BeetleCore\Fields;

class CheckboxField extends BasicField
{

    protected static $order = true;
    protected static $search = false;

    public function save($data)
    {
        if (!empty($data[$this->field])) {
            return [$this->field => "Y"];
        } else {
            return [$this->field => "N"];
        }
    }

    public function show($records)
    {
        if (!empty($records)) foreach ($records as $k => $i) {
            if (!empty($records[$k]->getAttribute($this->field)) AND $records[$k]->getAttribute($this->field) == "Y") {
                $records[$k]->setAttribute($this->field, "Да");
            } else {
                $records[$k]->setAttribute($this->field, "Нет");
            }
        }
        return $records;
    }

}
