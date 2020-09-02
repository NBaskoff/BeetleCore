<?php

namespace BeetleCore\Model;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{

	/**
	 * Название модуля
	 * @var string
	 */
	public $name = "";
	/**
	 * Описание модуля
	 * @var string
	 */
	public $description = "";
	/**
	 * @var string поле где содерджится имя записи
	 */
	public $field_name = "name";
	/**
	 * @var string поле для определания позиции
	 */
	public $position = "";
	protected $fields = [];
	protected $settings = [];
	protected $relations = [];
	protected $guarded = []; //чтобы можно было заполнять поля
	protected $links = [];
	protected $linkSelf = "";


	public function getFields()
	{
		return $this->fields;
	}

	public function getShowFields()
	{
		$fields = $this->getFields();
		if (!empty($fields)) foreach ($fields as $k => $field) {
			if (isset($field["show"]) and $field["show"] === false) {
				unset($fields[$k]);
			}
		}
		return $fields;
	}

	public function getLinks()
	{
		return $this->links;
	}

	public function dragAndDrop($data)
	{
		$ids = [];
		if (!empty($data)) {
			foreach ($data as $k => $i) {
				$ids[] = $i[0];
			}
			$positions = static::query()->whereIn($this->primaryKey, $ids)->pluck($this->position, $this->primaryKey)->toArray();
			foreach ($data as $k => $i) {
				static::find((int)$i[0])->update([$this->position => $positions[(int)$i[1]]]);
			}
		}
	}

	public function getShowRecords($parent, $id)
	{
		$records = $this::query();
		if (!empty($parent)) {
			$explodeParent = explode(".", $parent);
			$parentModel = $this->{$explodeParent[0]}()->getRelated();
			$ids = $parentModel::find($id)->{$explodeParent[1]}()->getQuery()->pluck($this->getTable() . "." . $this->getKeyName());
			$records = $records->whereIn($this->getKeyName(), $ids);
		}
		if (isset($parent) and !empty($this->linkSelf)) {
			$explodeParent = explode(".", $this->linkSelf);
			$records = $records->where($this->{$explodeParent[1]}()->getForeignKeyName(), $id);
		}
		if (!empty($this->position)) {
			$records = $records->orderBy($this->position);
		}
		return $records;
	}

	public function getLinkSelf()
	{
		return $this->linkSelf;
	}

	public function del()
	{
		if (!empty($this->linkSelf)) {
			$link = explode(".", $this->linkSelf);
			$ids = $this->{$link[1]}()->getQuery()->get($this->getKeyName());
			foreach ($ids as $k => $i) {
				$i->del();
			}
		}
		$this->delete();
	}

	public static function shotName()
	{
		return substr(strrchr(get_called_class(), "\\"), 1);
	}

	public function getSelfChildId()
	{
		$ids = [$this->getAttribute($this->getKeyName())];
		if (!empty($this->linkSelf)) {
			$link = explode(".", $this->linkSelf);
			$child = $this->{$link[1]};
			foreach ($child as $k => $i) {
				$ids = array_merge($ids, $i->getSelfChildId());
			}
		}
		return $ids;
	}

	public function getSelfBreadCrumbs()
	{
		$breadCrumb = [];
		if (!empty($this->linkSelf)) {
			$link = explode(".", $this->linkSelf);
			$breadCrumb[] = ["id" => $this->getAttribute($this->getKeyName()), "name" => $this->getAttribute($this->field_name)];
			$parent = $this->{$link[0]};
			if (!empty($parent)) {
				$breadCrumb = array_merge($parent->getSelfBreadCrumbs(), $breadCrumb);
			}
		}
		return $breadCrumb;
	}
}