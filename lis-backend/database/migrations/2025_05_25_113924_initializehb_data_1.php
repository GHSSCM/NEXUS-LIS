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
         $labId = "HB_".\Illuminate\Support\Str::random(8);

    
        \App\Models\UserAccount::create([
            'facility_ref'=>$labId,
            'name'=>"GHSSCM ADMIN",
            'username'=>"GHSSCM",
            'email'=>"ghsscm@ghsscm.org",
            "phone"=>"2376123456",
            "password"=>sha1("GHSSCM"),
        ]);


        // \App\Models\CustomField::create([
        //     'facility_ref'=>$labId,
        //     'name'=>"Laboratory Section",
        //     'type'=>"limitedvalues",
        //     'category'=>"test",
        //     "meta"=>[
        //         "enum"=>["Change me1","Change me2"]
        //     ]
        // ]);

        // \App\Models\CustomField::create([
        //     'facility_ref'=>$labId,
        //     'name'=>"Hospital Section",
        //     'type'=>"limitedvalues",
        //     'category'=>"patient",
        //     "meta"=>[
        //         "enum"=>["Change me1","Change me2"]
        //     ]
        // ]);

        \App\Models\Facility::create([
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
