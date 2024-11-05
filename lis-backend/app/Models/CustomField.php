<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomField extends Model
{
    use HasFactory;
    protected $casts = [
        'meta' => 'json',
    ];
    protected $table="customfields";
    protected $fillable=['name','type','category','meta','lab_ref','uniqid'];
    use SoftDeletes;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($type) {
            $type->uniqid = gen_uniqid();
        });
    }
}
