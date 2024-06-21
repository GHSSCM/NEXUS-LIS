<?php

use App\Models\CustomField;
use App\Models\Laboratory;
use App\Models\UserAccount;
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
        $labId = "LAB_".\Illuminate\Support\Str::random(8);

        UserAccount::create([
            'lab_ref'=>$labId,
            'name'=>"GHSSCM ADMIN",
            'username'=>"GHSSCM",
            'email'=>"ghsscm@ghsscm.org",
            "phone"=>"2376123456",
            "password"=>sha1("GHSSCM"),
        ]);


        CustomField::create([
            'lab_ref'=>$labId,
            'name'=>"Laboratory Section",
            'type'=>"limitedvalues",
            'category'=>"test",
            "meta"=>[
                "enum"=>["Change me1","Change me2"]
            ]
        ]);

        CustomField::create([
            'lab_ref'=>$labId,
            'name'=>"Hospital Section",
            'type'=>"limitedvalues",
            'category'=>"patient",
            "meta"=>[
                "enum"=>["Change me1","Change me2"]
            ]
        ]);

        Laboratory::create([
            'ref'=>$labId,
            'name'=>$labId,
            "meta"=>[
                "currency"=>"FCFA"
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
