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
        Schema::table('patients', function (Blueprint $table) {

            $table->string('reference')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('region')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('profession')->nullable()->change();
            $table->string('meta')->nullable()->change();
            $table->string('uniqid')->nullable()->change();
            $table->string('patient_id')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('extraid')->nullable()->change();
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
