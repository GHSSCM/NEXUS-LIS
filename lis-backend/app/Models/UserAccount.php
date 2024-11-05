<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $fillable=['name','email','phone','password','username','lab_ref','uniqid'];
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($account) {
            $account->uniqid = gen_uniqid();
        });
    }
    
}
