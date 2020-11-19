<?php

namespace BeetleCore\Fields;

class DateTime extends Basic
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
}
