<?php
namespace App\BeetleCMS;

use BeetleCore\Fields\Textarea;
use BeetleCore\Fields\Textbox;
use BeetleCore\Validators\NoEmpty;
use BeetleCore\Validators\Unique;

class NameModel extends Admin
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
            "type" => Textbox::class,
            "validators" => [
                [NoEmpty::class],
                //[Unique::class]
            ],
        ],
        "title" => [
            "name" => "SEO title",
            "type" => Textbox::class,
            "show" => false,
            "find" => false,
            "tab" => "SEO"
        ],
        "description" => [
            "name" => "SEO description",
            "type" => Textarea::class,
            "show" => false,
            "find" => false,
            "tab" => "SEO"
        ],
        "keywords" => [
            "name" => "SEO keywords",
            "type" => Textarea::class,
            "show" => false,
            "find" => false,
            "tab" => "SEO"
        ],
    ];
}
