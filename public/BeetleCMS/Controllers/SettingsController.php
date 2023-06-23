<?php


namespace App\BeetleCMS\Controllers;

use BeetleCore\Controllers\SettingsController as BeetleCoreSettingsController;

class SettingsController extends BeetleCoreSettingsController
{
	protected $model = \App\BeetleCMS\SettingsModel::class;
}
