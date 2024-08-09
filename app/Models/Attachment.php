<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachment';

    protected $fillable = [
        'name',
        'path',
        'type',
        'group',
        'ref_id'
    ];
}
