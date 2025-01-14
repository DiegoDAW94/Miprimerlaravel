<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'country',
        'zipcode',
        'email'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
