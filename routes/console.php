<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('beetle:make {name} {table?}', function ($name, $table = null) {
    BeetleCore\Console\Make::start($name, $table);
});
