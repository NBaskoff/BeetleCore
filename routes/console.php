<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

Artisan::command('beetle:make {name} {table?}', function ($name, $table = null) {
    if ($table == null) {
        $table = Str::of($name)->snake();
    }
    $templateDir = realpath(__DIR__ . "/../resources/templates");
    //model
    $template = file_get_contents("$templateDir/Model.php");
    $template = str_replace("NameModel", $name, $template);
    $template = str_replace("NameTable", $table, $template);
    file_put_contents(app_path("/BeetleCMS/$name.php"), $template);
    //controller
    $template = file_get_contents("$templateDir/Controller.php");
    $template = str_replace("NameModel", $name, $template);
    $template = str_replace("NameTable", $table, $template);
    file_put_contents(app_path("/BeetleCMS/Controllers/$name.php"), $template);
    //migration
    $template = file_get_contents("$templateDir/migration.php");
    $template = str_replace("NameModel", $name, $template);
    $template = str_replace("NameTable", $table, $template);
    file_put_contents(database_path("/migrations/" . date("Y_m_d_His") . "_create_{$table}_table.php"), $template);
    //echo web.php string
    $url = Str::of($name)->snake();
    echo 'Route::match(["get", "post"], "/' . $url . '/$urlType", App\BeetleCMS\Controllers\\' . $name . '::class)->name("admin.' . $url . '");';
});



