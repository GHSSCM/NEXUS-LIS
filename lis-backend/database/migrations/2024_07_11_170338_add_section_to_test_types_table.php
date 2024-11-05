<?php

use App\Models\CustomField;
use App\Models\TestType;
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
        Schema::table('test_types', function (Blueprint $table) {
            $table->string('lab_section')->nullable();
        });
        CustomField::query()->where(['category'=>'test'])->delete(); //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_types', function (Blueprint $table) {
            //
        });
    }
};
