<?php

namespace BeetleCore\Fields;

class Images extends Basic
{

    protected static $order = false;
    protected static $search = false;

    public function save($data)
    {
        $images = [];
        if (!empty($data[$this->field])) foreach ($data[$this->field] as $k => $i) {
            $images[] = json_decode($i, true);
        }
        return [$this->field => json_encode($images)];
    }

    protected function standart($data, $action)
    {
        $field = $this->field;
        $value = [];
        if (!empty($data[$field]) AND is_string($data[$field])) {
            $value = json_decode($data[$field], true);
        }
        if (!empty($data[$field]) AND is_array($data[$field])) {
            foreach ($data[$field] as $k=>$i) {
                $value[] = json_decode($i, true);
            }
        }

        $class = $this;
        return view("fields." . $this->shotName(), compact("action", "value", "class", "field"))->toHtml();
    }

    public function show($records)
    {
        if (!empty($records)) foreach ($records as $k => $i) {
            if (!empty($records[$k]->getAttribute($this->field))) {
                $images = json_decode($records[$k]->getAttribute($this->field), true);
                if (!empty($images[0])) {
                    $records[$k]->setAttribute($this->field, "<img src='{$images[0]["small"]}'>");
                }
            } else {
                $records[$k]->setAttribute($this->field, "");
            }
        }
        return $records;
    }

}
