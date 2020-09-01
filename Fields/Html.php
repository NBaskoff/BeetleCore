<?php

namespace App\Beetle\Fields;

class Html extends Basic
{

    protected static $order = true;
    protected static $search = true;
    public function save($data)
    {
        $html = trim($data[$this->field]);
        $url = $_SERVER["HTTP_HOST"];
        $html = str_replace("http://$url", "", $html);
        $html = str_replace("https://$url", "", $html);
        return [$this->field => $html];
    }
}
