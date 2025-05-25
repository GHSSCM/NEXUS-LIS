<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $fillable=['name','email','phone','password','username','facility_ref','uniqid','perms'];
    use HasFactory;

    protected $casts = [
        'perms' => 'array', // Ensure it's an array
    ];

    protected $attributes = [
        'perms' => '[]', // JSON default (as a string)
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($account) {
            $account->uniqid = gen_uniqid();
        });
    }
    
}
