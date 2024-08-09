<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $fillable = [
        'city',
        'iso2',
        'iso3',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'iso3', 'alpha_3');
    }
}
