<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tour extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'package_tours';

    protected $fillable = [
        'title',
        'sub_desc',
        'desc',
        'city_id',
        'start_date',
        'end_date',
        'duration',
        'tour_type_id',
        'price'
    ];

    public $translatable = ['title', 'sub_desc', 'desc'];

    public function tourType()
    {
        return $this->belongsTo(TourType::class, 'tour_type_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function AttachFile()
    {
        return $this->hasMany(Attachment::class, 'ref_id')->where('group', 'tour')->where('type', '!=', 'pdf');
    }

    public function AttachFilePdf()
    {
        return $this->hasMany(Attachment::class, 'ref_id')->where('group', 'tour')->where('type', 'pdf');
    }
}
