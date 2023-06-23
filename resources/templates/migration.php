<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("NameTable", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum("active", ["Y", "N"])->default("Y")->index();
            $table->integer("position")->index();
            $table->string("name");
            $table->text("title")->nullable();
            $table->text("description")->nullable();
            $table->text("keywords")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("NameTable");
    }
};
