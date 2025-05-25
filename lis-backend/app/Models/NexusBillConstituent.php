<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NexusBillConstituent extends Model
{
    use HasFactory;

    use SoftDeletes;


    protected $guarded=[];
    
    protected $casts = [
        'meta' => 'json'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($con) {
            $con->uniqid = gen_uniqid();
             if(empty($con->meta)){
                $con->meta=['a'=>'b'];
            }
        });
    }

}
