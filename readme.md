# BeetleCore

[![Latest Stable Version](http://poser.pugx.org/nbaskoff/beetlecore/v)](https://packagist.org/packages/nbaskoff/beetlecore)
[![Total Downloads](http://poser.pugx.org/nbaskoff/beetlecore/downloads)](https://packagist.org/packages/nbaskoff/beetlecore)
[![Latest Unstable Version](http://poser.pugx.org/nbaskoff/beetlecore/v/unstable)](https://packagist.org/packages/nbaskoff/beetlecore)
[![License](http://poser.pugx.org/nbaskoff/beetlecore/license)](https://packagist.org/packages/nbaskoff/beetlecore)
[![PHP Version Require](http://poser.pugx.org/nbaskoff/beetlecore/require/php)](https://packagist.org/packages/nbaskoff/beetlecore)

BeetleCMS (CRUD) for Laravel

<img src="https://ns100.ru/beetlecms/1.png" border="0">
<img src="https://ns100.ru/beetlecms/2.png" border="0">
<img src="https://ns100.ru/beetlecms/3.png" border="0">

```php
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
    ];
    protected $settings = [];
    protected $links = [
        //"colors.pages" => ["admin.color", "Цвета"],
    ];

}
```


## Installation

### With Composer

```
$ composer require nbaskoff/beetlecore
$ php artisan vendor:publish --tag=beetlecore-start        
```
## Docs

Сoming soon
