<?php


namespace BeetleCore\Controllers;

use BeetleCore\Models\Table;
use BeetleCore\Form;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic;

class Relation
{
    protected $namespace = "App\\Admin\\";

    public function form($model)
    {
        $model = $this->namespace . $model;
        /** @var $model Table */
        $model = new $model;
        $fields = $model->getFields();
        if (!empty($model->getLinkSelf())) {
            unset($fields[explode(".", $model->getLinkSelf())[1]]);
        }
        $form = new Form(new $model, null, $fields);
        $html = $form->renderFind([]);
        $ids = \request()->get("ids", []);
        if (!empty($ids)) {
            $records = $model::query()->whereIn($model->getKeyName(), $ids)->get([$model->getKeyName(), $model->nameKey])->toArray();
            $ids = [];
            if (!empty($records)) foreach ($records as $k => $i) {
                $ids[] = [
                    "id" => $i[$model->getKeyName()],
                    "name" => $i[$model->nameKey],
                ];
            }
        } else {
            $ids = [];
        }
        return view("beetlecore::relation_form", compact("model", "html", "ids"));
    }

    public function table($model)
    {
        /** @var $model Table */
        $model = $this->namespace . $model;
        $model = new $model;
        $ids = \request()->get("ids", []);
        $fields = $model->getShowFields();
        $parent = request("parent", 0);
        $find = request()->get("find", []);
        if (!empty($find)) {
            parse_str($find, $find);
        }

        if (empty($find)) {
            if (!empty($model->getLinkSelf())) {
                if (!empty($parent)) {
                    $records = $model->getShowRecords($model->getLinkSelf(), request("parent"));
                } else {
                    $records = $model->getShowRecords(0, 0);
                }
            } else {
                $records = $model->getShowRecords(NULL, NULL);
            }
        } else {
            $records = $model->getShowRecords(NULL, NULL);
        }

        $form = new Form(new $model);
        if (!empty(request("ignore"))) {
            $records = $records->whereNotIn($model->getKeyName(), explode(",", request("ignore")));
        }
        $records = $form->createFind($records, $find)->paginate(10, ["*"], "page", \request()->get("page", 1));
        $records = $form->renderShow($records);
        $breadCrumbs = [];
        if (!empty($parent)) {
            $record = $model::query()->find($parent);
            $breadCrumbs = $record->getSelfBreadCrumbs();
        }
        return view("beetlecore::relation_table", compact("records", "fields", "ids", "model", "breadCrumbs"));
    }
}
