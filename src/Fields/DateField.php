<?php

namespace BeetleCore\Fields;

class DateField extends BasicField
{
    protected static $order = true;
    protected static $search = false;
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
