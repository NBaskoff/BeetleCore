<?php


namespace BeetleCore\Models;

use BeetleCore\Fields\PasswordField;
use BeetleCore\Fields\TextboxField;
use BeetleCore\Validators\NoEmpty;
use BeetleCore\Validators\Unique;
use Illuminate\Support\Facades\Hash;

class UserAdminModel extends TableModel
{
	protected $table = "user_admin";
	public $modelName = "Администраторы";
	protected $fields = [
		"name" => [
			"name" => "Имя",
			"type" => TextboxField::class,
		],
		"login" => [
			"name" => "Логин",
			"type" => TextboxField::class,
			"validators" => [
				[NoEmpty::class],
				[Unique::class]
			],
		],
		"password" => [
			"name" => "Пароль",
			"type" => PasswordField::class,
			"show" => false
		],
	];
	public $timestamps = false;

	public static function auth($login, $pass)
	{
		$user = static::query()->where("login", $login)->first();
		if (!empty($user)) {
			if (!Hash::check($pass, $user->getAttribute("password"))) {
				$user = null;
			}
		}
		return $user;
	}

}
