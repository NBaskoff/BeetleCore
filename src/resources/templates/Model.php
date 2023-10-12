<?php
namespace App\BeetleCMS;

use BeetleCore\Fields\TextareaField;
use BeetleCore\Fields\TextboxField;
use BeetleCore\Validators\NoEmpty;
use BeetleCore\Validators\Unique;

class NameModelModel extends AdminModel
{
    protected $table = "NameTable";
    public $modelName = "Новый раздел";
    public $modelDescription = "";
    public $activeKey = "active";
    public $positionKey = "position";
    public $nameKey = "name";
    protected $fields = [
        "name" => [
            "name" => "Название",
            "type" => TextboxField::class,
            "validators" => [
                [NoEmpty::class],
                //[Unique::class]
            ],
        ],
        "title" => [
            "name" => "SEO title",
            "type" => TextboxField::class,
            "show" => false,
            "find" => false,
            "tab" => "SEO"
        ],
        "description" => [
            "name" => "SEO description",
            "type" => TextareaField::class,
            "show" => false,
            "find" => false,
            "tab" => "SEO"
        ],
        "keywords" => [
            "name" => "SEO keywords",
            "type" => TextareaField::class,
            "show" => false,
            "find" => false,
            "tab" => "SEO"
        ],
    ];
}
