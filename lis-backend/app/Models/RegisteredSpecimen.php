<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegisteredSpecimen extends Model
{
    use HasFactory;


     
    use SoftDeletes;


    protected $fillable=['uniqid','specimen','test','patient','facility_ref','receptiondate','meta',
    'receptiontime','state','physician','preleveur','referredout','referredin','conformity','referredto','validatedat','enteredat','placeofcollection','testingdate','testingtime',
'technique','groupID','clinical','sample_quality','sample_quality_reason','collectiontime','collectiondate'];
    

    protected $casts = [
        'meta' => 'json',
        'referredout'=>'boolean',
        'conformity'=>'boolean'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($type) {
            $type->uniqid = gen_uniqid();
        });
    }
}
