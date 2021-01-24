<?php


namespace BeetleCore\Fields;


class RelationTable extends Basic
{
    protected static $search = false;


    protected function standart($data, $action)
    {
        //узнаем на какую модель ссылается жта связь
        $model = $this->record->{$this->field}()->getRelated();
        //Узнаем на какие модели ссылаются все остальные связи
        $models = [];
        $records = $this->record->{$this->field}()->getQuery();
        foreach ($this->relations as $k => $i) {
            if (!is_array($i)) {
                $records = $records->with($k);
                $models[$k] = $model->{$k}()->getRelated();
            } else {
                $models[$k] = $i;
            }
        }
        $records = $records->orderBy($model->getKeyName())->get();
        $value = "";
        if (!empty($data[$this->field])) {
            $value = $data[$this->field];
        }
        $class = $this;
        return view("beetlecore::fields." . class_basename($this
            ), compact("action", "value", "class", "model", "models", "records"))->toHtml();
    }

    public function getDateCopy()
    {
        //узнаем на какую модель ссылается жта связь
        $model = $this->record->{$this->field}()->getRelated();
        //Узнаем на какие модели ссылаются все остальные связи

        $models = [];
        foreach ($this->relations as $k => $i) {
            if (!is_array($i)) {
                $models[$k] = $model->{$k}()->getRelated();
            } else {
                $models[$k] = $i;
            }
            //$models[$k] = $model->{$k}()->getRelated();
        }
        $records = $this->record->{$this->field};
        $lines = [];
        foreach ($records as $k => $i) {
            foreach ($models as $mk => $mi) {
                if (is_array($mi)) {
                    if ($mi["type"] == "Image") {
                        if (!empty($i->$mk)) {
                            $images = json_decode($i->$mk, true);
                            if (!empty($images)) foreach ($images as $kImage => $iImage) {
                                $images[$kImage] = json_encode($iImage);
                            }
                            $lines[$k][$mk] = $images;
                        } else {
                            $lines[$k][$mk] = "";
                        }
                    } else {
                        $lines[$k][$mk] = $i->$mk;
                    }

                } else {
                    if (get_class($i->{$mk}()) == "Illuminate\Database\Eloquent\Relations\BelongsToMany") {
                        foreach ($i->{$mk} as $item) {
                            if (!empty($item[$mi->getKeyName()])) {
                                $lines[$k][$mk]["id"][] = $item[$mi->getKeyName()];
                                $lines[$k][$mk]["name"][] = $item[$item->nameKey];
                            }
                        }
                    } else {
                        if (!empty($i->{$mk}[$mi->getKeyName()])) {
                            $lines[$k][$mk]["id"][] = $i->{$mk}[$mi->getKeyName()];
                            $lines[$k][$mk]["name"][] = $i->{$mk}[$i->{$mk}->nameKey];
                        }

                    }
                }
            }
            //$lines[$k]["id"] = $i->{$i->getKeyName()};
            $lines[$k]["id"] = "new";
        }
        return [$this->field => $lines];
    }

    public function save($data)
    {
        return [];
    }

    public function afterSave($data)
    {
        if (!empty($data[$this->field])) {
            $data = $data[$this->field];
            unset($data["|line|"]);
            $ids = [];
            if (!empty($data)) foreach ($data as $k => $i) {
                if ($i["id"] == "new") {
                    $model = $this->record->{$this->field}()->getRelated();
                    $model->save();
                    $ids[] = $model->getAttribute($model->getKeyName());
                } else {
                    $model = $this->record->{$this->field}()->find((int)$i["id"]);
                    $ids[] = (int)$i["id"];
                }
                foreach ($this->relations as $rk => $ri) {
                    if (is_array($ri)) {
                        if ($ri["type"] == "Image") {
                            $images = [];
                            if (!empty($i[$rk])) foreach ($i[$rk] as $kImage => $iImage) {
                                $images[] = json_decode($iImage, true);
                            }
                            $model->$rk = json_encode($images);
                        } else {
                            $model->$rk = $i[$rk];
                        }
                    } else {
                        if (!empty($i[$rk])) {
                            if (get_class($model->{$rk}()) == "Illuminate\Database\Eloquent\Relations\BelongsToMany") {
                                $model->{$rk}()->sync($i[$rk]["id"]);
                            } else {
                                $key = $model->$rk()->getLocalKeyName();
                                $model->$key = $i[$rk]["id"][0];
                            }
                        } else {
                            if (get_class($model->{$rk}()) == "Illuminate\Database\Eloquent\Relations\BelongsToMany") {
                                $model->{$rk}()->sync([]);
                            } else {
                                $key = $model->$rk()->getLocalKeyName();
                                $model->$key = 0;
                            }
                        }
                    }
                }
                $this->record->{$this->field}()->save($model);
            }
            $model = $this->record->{$this->field}();
            $model->whereNotIn($model->getRelated()->getKeyName(), $ids)->delete();
        } else {
            $this->record->{$this->field}()->delete();
        }
        return true;
    }
}


