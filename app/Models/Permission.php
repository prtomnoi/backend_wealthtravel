<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'role_id',
        'group',
        'table_name',
        'create',
        'update',
        'delete',
        'view',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
