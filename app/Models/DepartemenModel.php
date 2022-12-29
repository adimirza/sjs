<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartemenModel extends Model
{
    use HasFactory;
    protected $table = 'departemen';
    protected $fillable = [
        'nama',
        'kategori',
        'created_by',
        'updated_by',
    ];
}
