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
        Schema::table('test_types', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->boolean('hidename')->nullable()->change();
            $table->string('threshold')->nullable()->change();
            $table->string('tat')->nullable()->change();
            $table->integer('cost')->nullable()->change();
            $table->string('tatunit')->nullable()->change();
        });

        Schema::table('specimen_types', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
