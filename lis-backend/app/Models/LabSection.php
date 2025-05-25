<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabSection extends Model
{
    use HasFactory;


    protected $fillable=['reference','facility_ref','name','description','techniques'];
  
  
    use SoftDeletes;


    protected $casts = [
        'meta' => 'json',
        'techniques' => 'json'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($labsection) {
            $labsection->uniqid = gen_uniqid();
            if(empty($labsection->meta)){
                $labsection->meta=['a'=>'b'];
            }
        });
    }


}
