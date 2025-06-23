<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmrTask extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = [
        'meta' => 'json',
        'payload'=> 'json',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uniqid = gen_uniqid();
             if(empty($model->meta)){
                $model->meta=['a'=>'b'];
            }
        });
    }

}
