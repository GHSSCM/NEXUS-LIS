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
        Schema::table('customfields', function (Blueprint $table) {
            $table->text('uniqid')->unique();
        });

        Schema::table('user_accounts', function (Blueprint $table) {
            $table->text('uniqid')->unique();
        });


        Schema::create('specimen_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('uniqid');
            $table->string('name');
            $table->string('lab_ref');
            $table->string('description');
            $table->json('meta');
        });
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specimen_types');
    }
};
