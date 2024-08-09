<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function city()
    {
        return $this->belongsToMany(City::class, 'cities', 'iso3', 'alpha_3');
    }
}
