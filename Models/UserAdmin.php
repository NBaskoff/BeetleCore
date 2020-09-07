<?php


namespace BeetleCore\Models;

use BeetleCore\Fields\Password;
use BeetleCore\Fields\Textbox;
use BeetleCore\Validators\NoEmpty;
use BeetleCore\Validators\Unique;
use Illuminate\Support\Facades\Hash;

class UserAdmin extends Table
{
	protected $table = "user_admin";
	public $modelName = "Администраторы";
	protected $fields = [
		"name" => [
			"name" => "Имя",
			"type" => Textbox::class,
		],		
		"login" => [
			"name" => "Логин",
			"type" => Textbox::class,
			"validators" => [
				[NoEmpty::class],
				[Unique::class]
			],
		],
		"password" => [
			"name" => "Пароль",
			"type" => Password::class,
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
