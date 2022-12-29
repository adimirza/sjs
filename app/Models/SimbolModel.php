<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimbolModel extends Model
{
    use HasFactory;
    protected $table = 'bs_simbol';
    protected $fillable = [
        'name',
        'class',
        'code',
    ];
}
