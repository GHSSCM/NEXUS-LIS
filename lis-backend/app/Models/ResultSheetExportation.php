<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultSheetExportation extends Model
{
    use HasFactory;
    protected $fillable = ['uniqid','facility_ref','html','registered_specimen'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($type) {
            $type->uniqid = gen_uniqid();
        });
    }
}
