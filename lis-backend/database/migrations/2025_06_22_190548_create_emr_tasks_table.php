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
        Schema::create('emr_tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uniqid')->unique();
            $table->string('collection')->nullable();
            $table->string('operation')->nullable();
            $table->string('patient_id')->nullable();
            $table->string('object_id')->nullable();
            $table->json('payload')->nullable();
            $table->string('endpoint_url')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'canceled'])->default('pending');
            $table->text('error_message')->nullable();
            $table->integer('attempts')->default(0);
            $table->timestamp('executed_at')->nullable();
            $table->timestamps();



          
            $table->softDeletes();
            $table->json("meta");
            $table->text("facility_ref");

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emr_tasks');
    }
};
