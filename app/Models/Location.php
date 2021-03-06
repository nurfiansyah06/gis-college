<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "locations";
    protected $fillable = [
        'title','description','long','lat','address','height','image'
    ];

    use HasFactory;
}
