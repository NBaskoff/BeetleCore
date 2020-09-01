<?php

namespace App\Beetle\Validator;

class NoEmpty extends Basic
{

    public function valid($value)
    {
        if (empty($value)) {
            return "Не может быть пустым";
        } else {
            return true;
        }
    }

}
