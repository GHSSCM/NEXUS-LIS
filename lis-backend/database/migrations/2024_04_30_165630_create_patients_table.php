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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("uniqid")->nullable(false)->unique();
            $table->string("patient_id")->nullable(false)->unique();
            $table->string("reference")->nullable(false)->unique();
            $table->string("name")->nullable(false);
            $table->date("dob");
            $table->string("gender");
            $table->text("region");
            $table->text("address");
            $table->text("profession");
            $table->json('meta');   
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
