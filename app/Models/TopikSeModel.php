<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopikSeModel extends Model
{
    use HasFactory;
    protected $table = 'topik_se';
    protected $fillable = [
        'nama',
        'created_by',
        'updated_by',
    ];
}
