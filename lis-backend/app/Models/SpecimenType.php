<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecimenType extends Model
{
    use HasFactory;

     
    use SoftDeletes;


    protected $fillable=['uniqid','name','lab_ref','description','meta'];

    protected $casts = [
        'meta' => 'json',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($type) {
            $type->uniqid = gen_uniqid();
        });
    }

}
