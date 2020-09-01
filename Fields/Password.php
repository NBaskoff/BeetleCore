<?php

namespace App\Beetle\Fields;

use Illuminate\Support\Facades\Hash;

class Password extends Basic
{

    protected static $order = false;
    protected static $search = false;

    public function save($data)
    {
        if (!empty($data[$this->field."_edit"])) {
            return [$this->field => Hash::make($data[$this->field])];
        } else {
            return [];
        }
    }

}
