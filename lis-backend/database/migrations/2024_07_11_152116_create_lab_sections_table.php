<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lab_sections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json("meta");
            $table->json("techniques")->nullable();
            $table->text("name");
            $table->text("description")->nullable();
            $table->text("lab_ref");
            $table->string('uniqid');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_sections');
    }
};
