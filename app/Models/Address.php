<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'idUser','houseNum', 'street', 'city', 'state','country','postalCode'
    ];

    protected $table = 'address';
}
