<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory;
 
    protected $table="patients";
    protected $fillable=['reference','lab_ref','name','gender','dob','region','address','profession','meta','uniqid','patient_id','phone','email','extraid'];
  
  
    use SoftDeletes;


    protected $casts = [
        'meta' => 'json',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            $patient->uniqid = gen_uniqid();
            if(!$patient->patient_id){
                $patient->patient_id= $patient->reference;
            }
        });
    }
}
