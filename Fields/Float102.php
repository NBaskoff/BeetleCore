<?php

namespace BeetleCore\Fields;

class Float102 extends Basic
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
