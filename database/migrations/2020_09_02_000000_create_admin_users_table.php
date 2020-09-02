<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create("admin_users", function (Blueprint $table) {
			$table->increments("id");
			$table->string("name")->index();
			$table->string("login")->index()->unique();
			$table->string("password");
			$table->rememberToken();
			$table->timestamps();
		});
		DB::table("admin")->insert([
			"name" => "admin",
			"login" => "admin",
			"password" => Hash::make("admin")
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("admin_users");
    }
}
