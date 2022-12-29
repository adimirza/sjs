<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;
    protected $table = 'bs_role';
    protected $fillable = [
        'nama',
        'deskripsi',
        'created_by',
        'updated_by',
    ];
}
