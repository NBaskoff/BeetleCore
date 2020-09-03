<?php
Route::match(['post'], "/system/image/size", "\\BeetleCore\\Controllers\\Image@size");
Route::match(['post'], "/system/image/load", "\\BeetleCore\\Controllers\\Image@load");
Route::match(['post'], "/system/relation/form/{model}", "\\BeetleCore\\Controllers\\Relation@form");
Route::match(['post'], "/system/relation/table/{model}", "\\BeetleCore\\Controllers\\Relation@table");