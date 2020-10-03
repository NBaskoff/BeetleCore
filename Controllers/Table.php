<?php

namespace BeetleCore\Controllers;

use BeetleCore\Form;
use Illuminate\Http\Request;

class Table
{
	/**
	 * @var \BeetleCore\Models\Table
	 */
	protected $model;
	protected $modelName = \BeetleCore\Models\Table::class;

	public function __construct(Request $request)
	{
		$this->model = new $this->modelName;
	}

	public function __invoke(Request $request, $action, $parent = 0, $id = 0, $record = 0)
	{
		if (method_exists($this, "action$action")) {
			return $this->{"action$action"}($parent, $id, $record);
		} else {
			abort(404);
		}
	}


	public function actionShow($parent, $id)
	{
		$fields = $this->model->getShowFields();
		if (!empty(request("find"))) {
			$records = $this->model->getShowRecords(NULL, NULL);
		} else {
			$records = $this->model->getShowRecords($parent, $id);
		}
		$form = new Form(new $this->model);
		$records = $form->createFind($records, request()->all())->paginate(50);
		$html = $form->renderFind(request()->all());
		$model = $this->model;
		$records = $form->renderShow($records);
		return view("beetlecore::show", compact("fields", "records", "model", "parent", "id", "html"));
	}

	public function actionAdd($parent, $id, $record)
	{
		return $this->addEdit($parent, $id, null, true);
	}

	public function actionEdit($parent, $id, $record)
	{
		return $this->addEdit($parent, $id, $record, false);
	}

	protected function addEdit($parent, $id, $record, $add)
	{
		if (!empty($record)) {
			$record = $this->model::query()->find($record);
		} else {
			if (!empty($parent)) {
				$filed = explode(".", $parent)[1];
				$record = new $this->model([$this->model->{$filed}()->getForeignKeyName() => $id]);
			} else {
				$record = new $this->model();
			}
		}
		$form = new Form($record);
		if (request()->method() == "POST") {
			if ($form->valid(request()->toArray()) === true) {
				$this->addEditBeforeSave($parent, $id, $record, $add);
				$form->save(request()->toArray(), $parent, $id);
				//return redirect()->route(request()->route()->getName(), ["action" => "show", "parent" => $parent, "id" => $id]);
                return redirect()->route("admin.back", ["count" => request("system_count_try"), "back" => request("back")]);
			}
			$html = $form->renderPost(request()->toArray());
		} elseif ($add) {
			$html = $form->renderAdd();
		} else {
			$html = $form->renderEdit($record);
		}
		$model = $this->model;
		return view("beetlecore::edit", compact("html", "model"));
	}

	protected function addEditBeforeSave($parent, $id, $record, $add) {

	}

	public function actionDragAndDrop()
	{
		$this->model->dragAndDrop(request()->get("row"));
	}

	public function actionDel($parent, $id, $record)
	{
		$this->model::query()->find($record)->del();
        return redirect()->route("admin.back", ["count" => 0, "back" => request("back")]);
	}

    public function actionActive()
    {
        $this->model->active(request()->get("id"), request()->get("value"));
	}
}
