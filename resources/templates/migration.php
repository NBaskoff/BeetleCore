<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNameModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("NameTable", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum("active", ["Y", "N"])->default("Y");
            $table->integer("position")->index()->index();
            $table->string("name");
            $table->text("title")->nullable();
            $table->text("description")->nullable();
            $table->text("keywords")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("NameTable");
    }
}
