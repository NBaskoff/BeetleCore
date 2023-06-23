<?php

namespace BeetleCore\Models;

class SettingsModel extends Table
{
	public $modelName = "Настройки сайта";
	protected $table = "settings";

    public static function getSetting($name, $jsonDecode = false)
    {
        $data = self::query()->where("name", $name)->first("value")->value;
        if ($jsonDecode) {
            $data = json_decode($data);
        }
        return $data;
    }
}
