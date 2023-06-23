<?php


namespace App\BeetleCMS;

use BeetleCore\Fields\HtmlField;
use BeetleCore\Fields\ImagesField;
use BeetleCore\Fields\IntegerField;
use BeetleCore\Fields\TextareaField;
use BeetleCore\Fields\TextboxField;

class SettingsModelModel extends \BeetleCore\Models\Settings
{
    protected $fields = [
        "title" => [
            "name" => "Название сайта",
            "type" => TextboxField::class,
        ],
        "favicon" => [
            "name" => "Favicon",
            "type" => ImagesField::class,
            "width" => 64,
            "height" => 64,
            "class" => "admin-image-background"
        ],
        "logo" => [
            "name" => "Логотип сверху",
            "type" => ImagesField::class,
            "width" => 180,
            "height" => 60,
            "class" => "admin-image-background"
        ],
        "logo_footer" => [
            "name" => "Логотип снизу",
            "type" => ImagesField::class,
            "width" => 180,
            "height" => 60,
            "class" => "admin-image-background"
        ],
        "phone" => [
            "name" => "Телефон",
            "type" => TextboxField::class,
        ],
        "time" => [
            "name" => "Время работы",
            "type" => TextboxField::class,
        ],
        "email" => [
            "name" => "Email",
            "type" => TextboxField::class,
        ],
        "address" => [
            "name" => "Адрес",
            "type" => TextboxField::class,
        ],
        "js" => [
            "name" => "JS скрипты (Яндекс метрика и т.д.)",
            "type" => TextareaField::class,
        ],
        "index_top1" => [
            "name" => "Текст на главной 1",
            "type" => TextareaField::class,
        ],
        "index_btn1" => [
            "name" => "Текст на кнопке 1",
            "type" => TextboxField::class,
        ],
        "index_top2" => [
            "name" => "Текст на главной 2",
            "type" => TextareaField::class,
        ],
        "index_btn2" => [
            "name" => "Текст на кнопке 2",
            "type" => TextboxField::class,
        ],
        "index_top3" => [
            "name" => "Текст на главной 3",
            "type" => TextareaField::class,
        ],
        "index_btn3" => [
            "name" => "Текст на кнопке 3",
            "type" => TextboxField::class,
        ],
        "catalog_text" => [
            "name" => "Текст в карточке товара",
            "type" => HtmlField::class,
        ],
        "sale_text" => [
            "name" => "Текст в Мои продажи",
            "type" => HtmlField::class,
        ],
        /*        "instagram" => [
                    "name" => "Картинки на главной инстаграмм",
                    "type" => Images::class,
                    "width" => 400,
                    "height" => 400,
                    //"class" => "admin-image-background"
                ],*/
        "catalog_html_text" => [
            "name" => "Текст в карточке товара",
            "type" => TextboxField::class,
        ],
        "cart_order_text" => [
            "name" => "Текст в корзине",
            "type" => HtmlField::class,
            "tab" => "Корзина"
        ],
        "cart_order_done" => [
            "name" => "Текст успешного оформления заказа",
            "type" => HtmlField::class,
            "tab" => "Корзина"
        ],
        "cart_mail" => [
            "name" => "Письмо при заказе клиенту",
            "type" => HtmlField::class,
            "tab" => "Корзина"
        ],
        "description" => [
            "name" => "description",
            "type" => TextareaField::class,
            "tab" => "SEO"
        ],
        "keywords" => [
            "name" => "keywords",
            "type" => TextareaField::class,
            "tab" => "SEO"
        ],

//Соц сети
        "url_site_whatsapp" => [
            "name" => "WhatsApp",
            "type" => TextboxField::class,
            "tab" => "Соц сети"
        ],
        "url_site_telegram" => [
            "name" => "Telegram",
            "type" => TextboxField::class,
            "tab" => "Соц сети"
        ],
        "url_site_instagram" => [
            "name" => "Instagram",
            "type" => TextboxField::class,
            "tab" => "Соц сети"
        ],
        "url_site_vk" => [
            "name" => "VK",
            "type" => TextboxField::class,
            "tab" => "Соц сети"
        ],
        "url_site_youtube" => [
            "name" => "YouTube",
            "type" => TextboxField::class,
            "tab" => "Соц сети"
        ],
        "catalogs_text" => [
            "name" => "Текст над товарами",
            "type" => HtmlField::class,
            "tab" => "Каталоги"
        ],
        "textile_text" => [
            "name" => "Текст над товарами",
            "type" => HtmlField::class,
            "tab" => "Ткани"
        ],
    ];
}
