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
        Schema::create('result_sheet_exportations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('uniqid');
            $table->string('lab_ref');
            $table->string('html');
            $table->integer('registered_specimen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_sheet_exportations');
    }
};
