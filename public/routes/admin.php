<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(["prefix" => "admin", "middleware" => ["beetle-authenticate"]], function () {
    Route::get("/", function () {
        return redirect()->route("admin.page", "show");
    })->name("admin.index");
    Route::get("/exit", "\\BeetleCore\\Controllers\\AuthController@exit")->name("admin.exit");
    Route::match(["get", "post"], "/settings", App\BeetleCMS\Controllers\SettingsController::class)->name("admin.settings");

    $urlType = "{action}/{parent?}/{parent_id?}/{record_id?}/";
    Route::match(["get", "post"], "/user_admin/$urlType", App\BeetleCMS\Controllers\UserAdminController::class)->name("admin.user_admin");
    Route::match(["get", "post"], "/page/$urlType", App\BeetleCMS\Controllers\PageController::class)->name("admin.page");

    /*
    Route::match(["get", "post"], "/catalog/$urlType", App\BeetleCMS\Controllers\Catalog::class)->name("admin.catalog");
    Route::match(["get", "post"], "/catalog_items/$urlType", App\BeetleCMS\Controllers\CatalogItems::class)->name("admin.catalog_items");
	*/

    Route::get("/phpinfo", function () {
        return phpinfo();
    });

    Route::match(["post"], "/system/form/load", "\\BeetleCore\\Controllers\\FormController@load");
    Route::match(["post"], "/system/form/save", "\\BeetleCore\\Controllers\\FormController@save");

    Route::match(["post"], "/system/image/size", "\\BeetleCore\\Controllers\\ImageController@size");
    Route::match(["post"], "/system/image/load", "\\BeetleCore\\Controllers\\ImageController@load");

    Route::match(["get", "post"], "/system/relation/form", "\\BeetleCore\\Controllers\\RelationController@form");
    Route::match(["get", "post"], "/system/relation/table", "\\BeetleCore\\Controllers\\RelationController@table");

    Route::post("/system/file/load", "\\BeetleCore\\Controllers\\FileController@load");

    Route::post("/system/location/city", "\\BeetleCore\\Controllers\\LocationVKController@city");
});
