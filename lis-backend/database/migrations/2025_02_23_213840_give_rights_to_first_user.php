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
       $user = \App\Models\UserAccount::find(1);
       if($user){
            $user->perms = array_map(fn($perm) => $perm->value, \App\Models\Permission::cases());
            $user->save();
       }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
