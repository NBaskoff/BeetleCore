<?php


namespace BeetleCore\Fields;


class Select extends Basic
{
    protected static $order = true;
    protected static $search = true;

    public $data = [];

    public function show($records)
    {
        if (!empty($records)) foreach ($records as $k => $i) {
            if (!empty($records[$k]->getAttribute($this->field)) and !empty($this->data[$records[$k]->getAttribute($this->field)])) {
                $records[$k]->setAttribute($this->field, $this->data[$records[$k]->getAttribute($this->field)]);
            }
        }
        return $records;
    }

}
