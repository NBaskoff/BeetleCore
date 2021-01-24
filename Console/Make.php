<?php

namespace BeetleCore\Console;

use Illuminate\Support\Str;

class Make
{
    public static function start($name, $table = null)
    {
        if ($table == null) {
            $table = Str::of($name)->snake();
        }
        $templateDir = realpath(__DIR__ . "/../resources/templates");
        self::createTemplate("$templateDir/Model.php", $name, $table, app_path("/BeetleCMS/$name.php")); //model
        self::createTemplate("$templateDir/Controller.php", $name, $table, app_path("/BeetleCMS/Controllers/$name.php")); //controller
        self::createTemplate("$templateDir/migration.php", $name, $table, database_path("/migrations/" . date("Y_m_d_His") . "_create_{$table}_table.php")); //migration
        //echo web.php string
        $url = Str::of($name)->snake();
        echo 'Route::match(["get", "post"], "/' . $url . '/$urlType", App\BeetleCMS\Controllers\\' . $name . '::class)->name("admin.' . $url . '");';
    }

    protected static function createTemplate($template, $nameModel, $nameTable, $file)
    {
        $template = file_get_contents($template);
        $template = str_replace("NameModel", $nameModel, $template);
        $template = str_replace("NameTable", $nameTable, $template);
        file_put_contents($file, $template);
    }
}
