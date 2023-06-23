<?php

namespace BeetleCore\Fields;

class UrlField extends BasicField
{

    protected static $order = true;
    protected static $search = true;
    protected $mask = "";

    public function show($records)
    {
        if (!empty($records)) foreach ($records as $k => $i) {
            $link = $i->getAttribute($this->field);
            if (!empty($this->mask)) {
                $link = str_replace("{url}", $link, $this->mask);
            }
            $link = "<a target='_blank' href='{$link}'>$link</a>";
            $records[$k]->setAttribute($this->field, $link);
        }
        return $records;
    }

}
