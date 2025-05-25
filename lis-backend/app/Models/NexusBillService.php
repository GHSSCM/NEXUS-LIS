<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NexusBillService extends Model
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

        static::creating(function ($data) {
            $data->uniqid = gen_uniqid();
             if(empty($data->meta)){
                $data->meta=['a'=>'b'];
            }
        });
    }

}
