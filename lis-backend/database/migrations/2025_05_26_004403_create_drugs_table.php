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
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('uniqid');
            $table->softDeletes();
            $table->json("meta");
            $table->text("facility_ref");

            $table->string("name");
            $table->string("description")->nullable();
            $table->string("code")->nullable();
            $table->string("type")->default("INJECTABLE");
            $table->string("state")->default("ACTIVE");
            $table->float("unit_price")->default(0);
            $table->float("unit")->default(0);


            $table->float("quantity")->default(0);

        });

        Schema::create('drug_inventory', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('uniqid');
            $table->softDeletes();
            $table->json("meta");
            $table->text("facility_ref");



            $table->text("drug_ref");
            $table->string("operation")->default("INPUT");
            $table->float("quantity")->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
