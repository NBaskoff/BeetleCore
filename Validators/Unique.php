<?php

namespace BeetleCore\Validators;

use Beetle\Filter;
use Beetle\MySQL;
use Beetle\Settings;

class Unique extends Basic
{

    function valid($value)
    {
        $id = $this->record->getAttribute($this->record->getKeyName());
        if (!empty($id)) {
            $count = $this->record::query()->where($this->field, $value)->where($this->record->getKeyName(), "<>", $id)->count();
        } else {
            $count = $this->record::query()->where($this->field, $value)->count();
        }
        if ($count > 0) {
            return "Такое значение уже есть";
        } else {
            return true;
        }
    }

}
