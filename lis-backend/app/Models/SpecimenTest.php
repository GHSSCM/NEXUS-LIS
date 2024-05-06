<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecimenTest extends Model
{
    use HasFactory;


     
    use SoftDeletes;


    protected $fillable=['specimen','test'];
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
