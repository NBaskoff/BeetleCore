<?php

namespace BeetleCore\Fields;

class HtmlField extends BasicField
{

    protected static $order = true;
    protected static $search = true;
    public function save($data)
    {
        if (array_key_exists($this->field, $data)) {
            $html = trim($data[$this->field]);
            $url = $_SERVER["HTTP_HOST"];
            $html = str_replace("http://$url", "", $html);
            $html = str_replace("https://$url", "", $html);
            return [$this->field => $html];
        } else {
            return false;
        }
    }
}
