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
        Schema::create('nexus_bill_constituents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('uniqid');
            $table->softDeletes();
            $table->json("meta");
            $table->text("nexus_bill_ref");
            $table->text("nexus_bill_service_ref")->nullable();


            $table->float("quantity")->default(1);
            $table->float("unit_price")->default(0);
            $table->float("subtotal")->default(0);
            $table->float("reduction")->default(0);
            $table->float("total")->default(0);




            $table->string("state")->default("ACTIVE");
            $table->string("name");
            $table->string("subname")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nexus_bill_constituents');
    }
};
