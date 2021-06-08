<?php

namespace BeetleCore\Fields;

class Textarea extends Basic
{
    protected static $order = true;
    protected static $search = true;

    public function show($records)
    {
        if (!empty($records)) foreach ($records as $k => $i) {
            $records[$k]->setAttribute($this->field, str_replace("\n", "<br>", $i->getAttribute($this->field)));
        }
        return $records;
    }
}
