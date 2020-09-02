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
		Schema::create("user_admin", function (Blueprint $table) {
			$table->increments("id");
			$table->string("name")->index();
			$table->string("login")->index()->unique();
			$table->string("password");
			//$table->rememberToken();
			$table->timestamps();
		});
		DB::table("user_admin")->insert([
			"name" => "admin",
			"login" => "admin",
			"password" => Hash::make("admin"),
			"created_at" => date("Y-m-d H:i:s"),
			"updated_at" => date("Y-m-d H:i:s")
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("user_admin");
    }
}
