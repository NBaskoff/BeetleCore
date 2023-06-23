<?php


namespace App\BeetleCMS;


use BeetleCore\Fields\HtmlField;
use BeetleCore\Fields\TextareaField;
use BeetleCore\Fields\TextboxField;
use BeetleCore\Fields\UrlField;
use BeetleCore\Validators\NoEmpty;
use BeetleCore\Validators\Unique;

class PageModel extends AdminModel
{
    protected $table = "page";
    public $modelName = "Страницы";
    public $modelDescription = "";
    public $positionKey = "position";
    public $canAdd = false;
    public $canDelete = false;

    protected $fields = [
        "name" => [
            "name" => "Название",
            "type" => TextboxField::class,
            "validators" => [
                [NoEmpty::class],
                [Unique::class]
            ],
        ],
        "link" => [
            "name" => "Адрес страницы (url)",
            "type" => UrlField::class,
            "mask" => "/page/{url}",
            "validators" => [
                [NoEmpty::class],
                [Unique::class]
            ],
        ],
        "title" => [
            "name" => "title",
            "type" => TextboxField::class,
            "show" => false,
            "find" => false,
            "tab" => "SEO"
        ],
        "description" => [
            "name" => "description",
            "type" => TextareaField::class,
            "show" => false,
            "find" => false,
            "tab" => "SEO"
        ],
        "keywords" => [
            "name" => "keywords",
            "type" => TextareaField::class,
            "show" => false,
            "find" => false,
            "tab" => "SEO"
        ],
        "body" => [
            "name" => "Текст",
            "type" => HtmlField::class,
            "show" => false
        ],
/*        "form_fields" => [
            "name" => "Поля формы",
            "type" => TextareaField::class,
            "show" => false,
            "find" => false,
        ],
        "form_body" => [
            "name" => "Текст после отправки формы",
            "type" => HtmlField::class,
            "show" => false
        ],*/
    ];
    protected $settings = [];
    protected $links = [
        //"colors.pages" => ["admin.color", "Цвета"],
    ];

}
