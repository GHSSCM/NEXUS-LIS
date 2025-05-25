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
       Schema::table('nexus_bill_services', function (Blueprint $table) {

     
            $table->dropColumn("quantity_unit");


        });
         Schema::table('nexus_bill_services', function (Blueprint $table) {

     
             $table->text("quantity_unit")->nullable();


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
