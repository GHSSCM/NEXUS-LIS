<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory;


    use SoftDeletes;

    protected $fillable = ["uniqid","meta","generatedby","specimen_id","total","patient","lab_ref"] ;
    //specimen_id is the uniqid of the registered_specimen and should only be used when it is one specimen we are billing for.

    protected $casts = [
        'meta' => 'json',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bill) {
            $bill->uniqid = gen_uniqid();
        });
    }

}
