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
          Schema::create('nexus_bills', function (Blueprint $table) {

            $table->id();
            $table->timestamps();
            $table->string('uniqid');
            $table->softDeletes();
            $table->json("meta");
            $table->text("facility_ref");

            
            $table->text("patient_ref");

            
            $table->float("amount")->default(0);
            $table->float("reduction")->default(0);
            

            $table->string("currency")->default("FCFA");
            $table->string("status")->default("PENDING");
            $table->string("payment_method")->default("CASH");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nexus_bills');
    }
};
