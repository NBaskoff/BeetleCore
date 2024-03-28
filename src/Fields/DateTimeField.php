<?php

namespace BeetleCore\Fields;

class DateTimeField extends BasicField
{
    protected static $order = true;
    protected static $search = false;

    public function edit($data)
    {
        if (!empty($data[$this->field])) {
            $data[$this->field] = str_replace(" ", "T", $data[$this->field]);
        }
        return $this->standart($data, "edit");
    }

    public function show($records)
    {
        if (!empty($records)) foreach ($records as $k => $i) {
            $records[$k]->setAttribute($this->field, str_replace("T", " ", $i->getAttribute($this->field)));
        }
        return $records;
    }

    public function save($data)
    {
        if (array_key_exists($this->field, $data)) {
            if (empty($data[$this->field])) {
                return [$this->field => null];
            } else {
                return [$this->field => trim($data[$this->field])];
            }
        } else {
            return false;
        }
    }
}
