<?php
namespace App\BeetleCMS;

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
    ];
}
