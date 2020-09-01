<?php

namespace App\Beetle\Fields;

class Integer extends Basic
{

    protected static $order = true;
    protected static $search = true;
    public function save($data)
    {
        if (!empty($data[$this->field])) {
            return [$this->field => trim($data[$this->field])];
        } else {
            return [$this->field => "0"];
        }

    }

}
