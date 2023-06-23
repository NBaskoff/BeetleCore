<?php

namespace BeetleCore\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;


class MakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beetlecore:make {name} {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = ucfirst($this->argument("name"));
        $table = $this->argument("table");
        if ($table == null) {
            $table = Str::of($name)->snake();
        }
        $templateDir = realpath(__DIR__ . "/../../resources/templates");
        self::createTemplate("$templateDir/Model.php", $name, $table, app_path("/BeetleCMS/$name.php")); //model
        self::createTemplate("$templateDir/Controller.php", $name, $table, app_path("/BeetleCMS/Controllers/{$name}Controller.php")); //controller
        self::createTemplate("$templateDir/migration.php", $name, $table, database_path("/migrations/" . date("Y_m_d_His") . "_create_{$table}_table.php")); //migration
        //echo web.php string
        $url = Str::of($name)->snake();
        echo 'Route::match(["get", "post"], "/' . $url . '/$urlType", App\BeetleCMS\Controllers\\' . $name . 'Controller::class)->name("admin.' . $url . '");';

    }

    protected static function createTemplate($template, $nameModel, $nameTable, $file)
    {
        $template = file_get_contents($template);
        $template = str_replace("NameModel", $nameModel, $template);
        $template = str_replace("NameTable", $nameTable, $template);
        file_put_contents($file, $template);
    }
}
