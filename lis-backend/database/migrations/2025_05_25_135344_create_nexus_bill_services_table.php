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
        Schema::create('nexus_bill_services', function (Blueprint $table) {

            $table->id();
            $table->timestamps();
            $table->string('uniqid');
            $table->softDeletes();
            $table->json("meta");
            $table->text("facility_ref");


            $table->boolean("quantifiable")->default(true);
            $table->float("unit_price")->default(0);
            $table->float("quantity_unit")->nullable();

            $table->string("state")->default("ACTIVE");
            $table->string("name");
            $table->string("description")->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nexus_bill_services');
    }
};
