<?php

namespace BeetleCore\Controllers;

use BeetleCore\Form;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
	/* @var \BeetleCore\Model\Settings */
	protected $model = \BeetleCore\Models\Settings::class;

	public function __invoke(Request $request)
	{
		$save = false;
		/* @var $record \BeetleCore\Model\Settings */
		$record = new $this->model;
        $fields = $record->getFields();
		$record->fill($this->model::query()->whereIn("name", array_keys($fields))->pluck("value", "name")->toArray());
		$form = new Form($record, null, $fields);
		if (request()->method() == "POST") {
			if ($form->valid(request()->toArray()) === true) {
				$records = $form->getSave(request()->toArray());
				foreach ($records as $k => $i) {
					$record::query()
						->where("name", $k)
						->firstOrCreate(["name" => $k], ["value"=>$i])
						->setAttribute("value", $i)
						->save();
				}
				$save = true;
			}
			$html = $form->renderPost(request()->toArray());
		} else {
			$html = $form->renderEdit($record);
		}
        $model = new $this->model;
        $tabs = [];
        foreach ($fields as $k => $i) {
            if (!empty($i["tab"])) {
                $tabs[$i["tab"]][] = $k;
            } else {
                $tabs["Главная"][] = $k;
            }
        }
		return view("beetlecore::settings", compact("html", "save", "model", "tabs"));
	}
}
