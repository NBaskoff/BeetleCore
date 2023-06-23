<?php

namespace BeetleCore\Controllers;

use BeetleCore\Form;
use Illuminate\Http\Request;

class TableController extends Controller
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
        $form = new Form(new $this->model, null, $this->model->getFindFields());
        $records = $form->createFind($records, request()->all())->paginate(100);
        $html = $form->renderFind(request()->all());
        $model = $this->model;
        $records = $form->renderShow($records);
        return view("beetlecore::show", compact("fields", "records", "model", "parent", "id", "html"));
    }

    public function actionAdd($parent, $parent_id)
    {
        return $this->addEdit($parent, $parent_id, 0);
    }

    public function actionEdit($parent, $parent_id, $record_id)
    {
        return $this->addEdit($parent, $parent_id, $record_id);
    }

    protected function addEdit($parent, $parent_id, $record_id)
    {
        $model = $this->model;
        $modelName = $this->modelName;
        $back = request("back");
        return view("beetlecore::edit", compact("parent", "parent_id", "record_id", "model", "modelName", "back"));
    }


    public function actionDragAndDrop()
    {
        $this->model->dragAndDrop(request()->get("row"));
    }

    public function actionDel($parent, $id, $record)
    {
        $this->model::query()->find($record)->del();
        return redirect(request("back"));
    }

    public function actionActive()
    {
        $this->model->active(request()->get("id"), request()->get("value"));
    }

    public function actionBulk($parent, $id)
    {
        if (empty(\request("records"))) {
            return redirect(request("back"));
        }
        /**
         * @var $record \BeetleCore\Models\Table
         */
        $record = new $this->model();
        if (\request("action") == "edit") {
            $fields = $record->getFields();
            $form = new Form($record, null, $fields);
            if (request()->method() == "POST") {
                foreach ($fields as $k => $i) {
                    if (empty(\request("system_replace")[$k])) {
                        unset($fields[$k]);
                    }
                }
                $form = $form->setFields($fields);
                if ($form->valid(request()->toArray()) === true) {
                    foreach (request("records") as $k => $i) {
                        $record = $this->model::query()->find($i);
                        $form = new Form($record);
                        $form = $form->setFields($fields);
                        //$this->addEditBeforeSave($parent, $id, $record);
                        $form->save(request()->toArray(), $parent, $id);
                    }
                    return redirect(request("back"));
                }
                $html = $form->renderPost(request()->toArray());
            } else {
                $html = $form->renderAdd();
            }
            $model = $this->model;
            return view("beetlecore::edit_bulk", compact("html", "model", "fields"));
        } elseif (\request("action") == "del") {
            $this->model::query()->whereIn($record->getKeyName(), \request("records", []))->delete();
            return redirect(request("back"));
        }
    }

    public function actionLoad($parent, $id)
    {
        /**
         * @var $record \BeetleCore\Models\Table
         */
        $record = new $this->model();
        $form = new Form($record);
        $fields = $record->getFields();
        $key = $record->getLoadKey();
        $name = $record->nameKey;
        $form->setFields([
            "name" => $fields[$name],
            "images" => $fields[$key],
        ]);
        if (request()->method() == "POST") {
            foreach (\request("images") as $k => $i) {
                $record = new $this->model();
                $form = new Form($record);
                $save = [
                    $key => [$i],
                    $name => str_replace("№", $k + 1, \request("name"))
                ];
                //$this->addEditBeforeSave($parent, $id, $record);
                $form->save($save, $parent, $id);
            }
            return redirect()->route(request()->route()->getName(), ["action" => "show", "parent_id" => $parent, "record_id" => $id]);
        }
        $html = $form->renderAdd();
        $model = $this->model;
        return view("beetlecore::load", compact("html", "model"));
    }
}
