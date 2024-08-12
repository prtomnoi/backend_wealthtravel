<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Reviews extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'desc',
        'by',
        'star',
        'path',
        'status'
    ];

    public $translatable = ['title', 'desc'];
}
