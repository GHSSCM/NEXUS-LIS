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
        Schema::create('registered_specimens', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->json('meta');
            $table->string('specimen');
            $table->string('test'); 
            $table->string('patient'); 
            $table->string('facility_ref'); 
            $table->date('receptiondate')->nullable(); 
            $table->time('receptiontime')->nullable(); 
            $table->string('state')->default("N/A"); 
            $table->string('physician')->nullable(); 
            $table->string('preleveur')->nullable(); 
            $table->boolean('referredout')->default(false); 
            $table->boolean('conformity')->default(false); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registered_specimens');
    }
};
