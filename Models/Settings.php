<?php

namespace BeetleCore\Models;

class Settings extends Table
{
	public $modelName = "Настройки сайта";
	protected $table = "settings";

	public static function getSetting($name)
	{
		return self::query()->where("name", $name)->first("value")->value;
	}
}